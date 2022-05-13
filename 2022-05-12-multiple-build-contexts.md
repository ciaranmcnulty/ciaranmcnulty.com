---
title: Building container images using Multiple Build Contexts and Dockerfiles
---

Dockerfile 1.4 has a new feature, 'multiple build contexts', and I've already found a few interesting use cases for it. 

There are plenty of write-ups about the details of this feature, including [this excellent one by Tonis Tiigi](https://www.docker.com/blog/dockerfiles-now-support-multiple-build-contexts/) so the main aim of this article is to show some cool stuff you can do with it.

# What are Multiple Build Contexts?

To get files into an image, we can:

 * COPY/ADD them from the build context
 * ADD a remote source
 * RUN something that generates files
 * COPY them from another image, or another build stage

The TL;DR version is that this new feature allows you to specify additional named build contexts, aside from the main one, from which you can fetch files.

In a 'normal' docker build you have exactly one 'build context'. Here it is the current folder:

```bash
docker buildx build .
```

The new feature allows you to specify more build contexts. Here we add an additional one called 'foo':

```bash
docker buildx build . --build-context foo=../bar 
```

When you `COPY --from=foo` the builder will look for following places, in priority order:

 1. *An additional named context* with that name (i.e. `--build-context foo=...`) - this is the new behaviour
 2. A local build stage with that name (i.e. `FROM ... AS foo`)
 3. An image with that reference (i.e. `docker.io/library/foo`) 

What makes this so powerful is that the additional contexts can be local files, various remote sources, or other docker images.

In all of these examples we use `buildx` because from version `0.8.0` it has a CLI argument to specify the additional contexts. 

It's expected that other builders will add ways to specify the additional contexts too (e.g. `docker compose` will have a way to add them in its Yaml format).

# Dependency Injection?

You'll see that in all the use cases below, the Dockerfile no longer needs to know where the files are coming from. All of the Dockerfiles now contain only a `COPY --from=<name>`, and to build from different sources we can change via the CLI invocation.

This adds a powerful new layer of indirection where Dockerfiles are far more reusable across different build environments.

For me this is the biggest advantage of the new functionality, and it makes me think that _in most cases we should be using this feature_ for maximum flexibility.

# Example use cases

Here are some cases I've found interesting, as a way to illustrate what's possible with this powerful new feature. I've tried not to overlap too much with the ideas in [Tonis Tiigi's article](https://www.docker.com/blog/dockerfiles-now-support-multiple-build-contexts/)

## Copying files from another location

For complicated/historical reasons, one of my projects needs to copy a single file from a 'special' location on the build server.

Before multiple build contexts you would have to either:
 1. Copy the files into the project folder before you build
 2. Make a hard link between files, which can get annoying when files are deleted
 3. Set the build context to be very broad

We went for option 1 and had to always use the `make` target to build the project, and to `.gitignore` the file so we didn't accidentally commit it back. This was not very clean.

Instead we can now add the extra location as a build context:

```bash
docker buildx build . --build-context special=/path/to/special/directory
```

And in the Dockerfile as usual it's just a `COPY`:

```Dockerfile
COPY --from=special magic_file.cert .
```

## Replacing a base image with an fork

One of my projects was based on a version of Wiremock that didn't support ARM64, so I built a multi-arch image myself. 

To be able to replace the base image at build time I had introduced a build argument:
```Dockerfile
ARG BASE_WM_IMAGE
FROM ${BASE_WM_IMAGE:-wiremock/wiremock:2.31} 
```

And then to replace the base image with my fork at build time I could provide that build argument:
```bash
docker buildx build . \
  --build-arg BASE_WM_IMAGE=ciaranmcnulty/wiremock-docker:latest
```

This added complexity to the build just to support my use case.

We can now go back to a clean Dockerfile:
```Dockerfile
FROM wiremock/wiremock:2.31
```

I can now replace the base image by matching my build context's name to the image reference:
```bash
docker buildx build . \
  --build-context wiremock/wiremock:2.31=docker-image://ciaranmcnulty/wiremock-docker:latest
```

## Breaking stages into separate Dockerfiles

On one project we have a large complex codebase, where separate stages are used for a frontend build pipeline that's maintained almost entirely independently, while the main application is in PHP.

A very simplified version would look like this:
```Dockerfile
FROM npm AS frontend-build
COPY frontend/scripts .
#[...JS build pipeline...]

FROM php AS final
#[...PHP-specific stuff...]
COPY --from=frontend-build /dist/* ./public/
```

As this scales it gets messy, and it'd make a lot of sense to be able to maintain multiple Dockerfiles. However, up until now we needed to maintain them in one file if we wanted an atomic local build.

The only way to split up the Dockerfile into subfolders would have required us to build the `frontend-build` stage separately, tag an image, push it to a registry, then reference that tag in the main build.

This would need  external coordination (e.g. `make`) to ensure everything was built in the right order, and would involve a registry for no reason.

We now do still need higher-level coordination, but this now can be done without a remote registry.

We can make a `frontend/Dockerfile` with and move the relevant stages into it:
```Dockerfile
FROM npm AS frontend-build
COPY ./scripts .
#[...JS build pipeline...]
```

We can leave the PHP stages in the main `Dockerfile` as-is:
```Dockerfile
FROM php AS final
#[...PHP-specific stuff...]
COPY --from=frontend-build /dist/* ./public/
```

And use `docker-bake.hcl` to plug them together:
```HCL
target "default" {
  contexts = {
    frontend-build = "target:frontend",
  }
}

target "frontend" {
  context = "./frontend"
}
```

To build this we will need to use `buildx bake` instead of `buildx build` as we're outputting multiple images:
```shell
docker buildx bake -f docker-bake.hcl
```

## Grabbing files from a private git repository

An existing project does something like this, to clone a private (GitLab) repository and then copy selected files out of it

```Dockerfile
FROM git AS git-src
RUN --mount=type=secret,id=git-token,target=/tmp/git_token \
  git clone https://oauth:$<(/tmp/git_token)@git.private-server.notreal/my-project#main 

FROM base-image AS final
COPY --from=git-src *.js .
```

As you can see there's a bit of indirection needed to be able to pass the secret token into the image.

The need for the first build stage, and the secrets handling, is removed if we provide the git repository as an additional build context:

```bash
docker buildx build . \
  --build-context git-src=https://oauth:${GIT_TOKEN}@git.private-server.notreal/my-project#main 
```

We are left with just this in the Dockerfile:

```Dockerfile
FROM base-image AS final
COPY --from=git-src /path/to/file .
```

The git repository will be cloned and retained, so rebuilding will only do the equivalent of a `git fetch` even if the layer is invalidated.

(Note that `COPY --from=https://git...` has never worked)

##  Copying files from an online tarball

In one project, I had to grab some files from another project's build artefact which was published as a `.tar.gz`. It looked something like this:

```Dockerfile
FROM alpine AS deps
ADD https://somefakeserver.notreal/downloads/latest.tar.gz .
RUN tar zxvf latest.tar.gz

FROM base-image AS final
COPY --from=deps /assets ./assets
```

(Note an `ADD` is used here because the URL doesn't change when the content does)

This can now be streamlined as you'd expect:

```bash
docker buildx build . --build-context deps=https://somefakeserver.notreal/downloads/latest.tar.gz
```

```Dockerfile
FROM base-image AS final
COPY --from=deps /assets ./assets
```

The downloaded `.tar.gz` is retained, so each rebuild will connect to the server to see if the contents are changed. This may not be exactly what you want if the URL would change when the contents do, in which case a `RUN`-based option would be better.
