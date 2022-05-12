# Building container images using Multiple Build Contexts and Dockerfiles

Dockerfile 1.4 has a new feature, 'multiple build contexts', and I've already found a few interesting use cases for it. 

There are plenty of write-ups about the details of this new feature, including [this excellent one by Tonis Tiigi](https://www.docker.com/blog/dockerfiles-now-support-multiple-build-contexts/) so the main aim of this article is to show some other cool stuff I've found that you can do with it.

## What's it about?

When building using a Dockerfile, you can get already add files to an image in lot of different ways:

 1. `COPY` or `ADD` them from a local filesystem build context (e.g. `docker build .`)
 2. `COPY` or `ADD` them from a remote build context (e.g. `docker build https://github.com/myrepo/myproject#branch`)
 3. `COPY` them `--from` another Docker reference (e.g. `COPY --from=composer:2.3 /usr/bin/composer`)
 4. `ADD` them from a URL (e.g. `ADD https://github.com/ubuntu/libreoffice/archive/refs/tags/7.3.3.2-20220428.tar.gz`)
 5. Generate them by `RUN`-ing some command, which could of course be doing a network operation (e.g. `RUN npm install`)
 6. `COPY` them `--from` a different build target (e.g. `COPY --from=deps /build/app.js /public/app.js`). In this case you need to have used one of the above methods to get them into that other target.

## What are Multiple Build Contexts?

The TL;DR version is that this new feature allows you to specify additional named build contexts aside from the main one.

For example, in a 'normal' docker build:

```bash
docker build .
```

You have exactly one 'build context' that is the current folder.

If you're using buildx you can now do this instead:

```bash
docker buildx build --build-context foo=../bar
```

You now have the main build context _and_ an additional context that's named 'foo'.

Here we have to use `buildx` because it has a CLI flag that lets us specify the additional contexts. It's expected that other builders (e.g. `docker compose`) will add ways to specify the additional contexts too (e.g. in Yaml).

The important change is that the Dockerfile behaviour has been clearly defined: when you `COPY --from=foo` this will now look at the following places in order:

 1. *A named additional context* (i.e. `--build-context foo=...`) - this is the new behaviour
 2. A local build stage with this name (i.e. `FROM ... AS foo`)
 3. An image with this reference (i.e. `registry.docker.com/_/foo`) 

## Is it Dependency Injection?

You'll see that in all the use cases below, the Dockerfile no longer knows where the files are coming from. 

All of the Dockerfiles now contain just a `COPY --from=<name>`, so to build from different sources we just need to change the CLI invocation.

For example it's trivial to use the same Dockerfile to get files from disk while developing:

```
--build-context other-project=../other-project
```

But then on a build server get it from a docker registry instead:

```
--build-context other-project=dockerfile://myregistry.com/other-project:lastest
```

By naming the copy source rather than hard-coding it into the Dockefile, a powerful layer of indirection is added. 

For me this is the biggest advantage of the new feature, and it makes me think that _in most cases we should be using this feature_ for maximum flexibility.

## Example use cases

Here are some cases I've found interesting, as a way to illustrate what's possible with this powerful new feature. I've tried not to overlap too much with the ideas in [Tonis Tiigi's article](https://www.docker.com/blog/dockerfiles-now-support-multiple-build-contexts/)

### Copying files from another local folder

Sometimes I might have my main project in one local checkout, and want to copy files in from another local checkout.

Before multiple build contexts you would have to either:
 1. Copy the files into the project folder before you built
 2. Set the build context to be very broad and add lots of path prefixes to everything

```bash
docker buildx build . --build-context seo=../seo
```

And in the Dockerfile as usual it's just a `COPY`:

```Dockerfile
COPY --from=seo /public/robots.txt /public
```

### Replacing an image with an alternative

One project uses a version of Wiremock that doesn't support ARM, so I build a multi-arch image myself and had to replace it when building. The old version started like this:

```Dockerfile
ARG BASE_WM_IMAGE
FROM ${BASE_WM_IMAGE:-wiremock/wiremock:2.31} 
```

So to use my forked image instead on my Apple Silicon device:\

```bash
docker buildx build --build-arg BASE_WM_IMAGE=ciaranmcnulty/wiremock:latest
```

This added complexity to the build just to support my use case. We can now revert it to this:

```Dockerfile
FROM wiremock/wiremock:2.31
```

And locally I can override how that string maps to an image reference:

```bash
docker buildx build . \
	--build-context wiremock/wiremock:2.31=docker-image://ciaranmcnulty/wiremock-docker:latest
```

### Breaking stages into separate Dockerfiles

On one project we have a large complex codebase, where separate build stages are heavily used and in fact are partly maintained by different teams.

This ends up with one big Dockerfile in the root, with fairly unrelated stages that look something like this:

```Dockerfile
FROM npm AS javascript-build
COPY js/* .
#[...JS build pipeline...]

FROM php AS php-build
COPY php/*
#[...PHP-specific stuff...]

FROM scratch AS final
COPY --from=javascript-build /built ./foo
COPY --from=php-build /built ./bar
```

Really it would make sense to split the build stages into the subfolders they operate on. 

Unfortunately currently the only way to split up the Dockerfile into subfolders would require us to also build the `-build` images separately, push them to a registry, then reference the tag used in the main build.

This is clearly not ideal, as external coordination is needed (e.g. Makefiles) to ensure references are pushed in the right order, plus we're involving a registry for no reason.

We do indeed still need higher-level coordination, but this can be done without a remote registry needed, using a `docker-bake.hcl`:

```HCL
target "default" {
	context = "."
  contexts = {
    javascript-build = "target:js",
    php-build = "target:php",
  }
}

target "js" {
  context = "./js"
}

target "php" {
  context = "./php"
}
```

This will let us have Dockerfiles in the `php` and `js` subfolders, and one in the root that copies them using the context names as before. To build this we will need to use `bake` instead:

```shell
docker buildx bake -f docker-bake.hcl
```

### Grabbing files from a private git repository

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

###  Copying files from an online tarball

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
