---
title: Testing Constructors with PhpSpec 2.3
tags: [ php, phpspec ]
---

At the weekend I tagged the first (hopefully only) beta release of PhpSpec 2.3.0. You can see the [details of the release here][1]

Several of the features relate to constructors, so I thought it was worth going through the differences to how you deal with
constructors when specifying classes.

 [1]: https://github.com/phpspec/phpspec/releases/tag/2.3.0-beta

# Describing construction in 2.2.x

Since the 2.0 release you have always been able to describe simple constructors:

```php
$this->beConstructedWith(100, 'param');
```

This works fine when describing `__construct` but a common pattern nowadays is to use Named Constructors. We did not have
a sensible way to describe them until [Jason](http://github.com/thecrimpmaster) added a neat syntax for doing this version 2.2.0:

```php
$this->beConstructedThrough('named', ['Ciaran']);
```

This describes a class that has somethng like the following implementation of a static class:

```php
public static function named($name)
{
    $user = new User();
    $user->name = $name;

    return $user;
}
```

Which allows the more readable:

```php
$user = User::named('Ciaran');
```

This opened up a lot of possibilities but there were a few issues:

 1. The public constructor still existed (Jason's original PR actually handled this but for some reason I got him to remove it).
 2. From observing people using the tool, it became apparent that using an array of parameters caused confusion.
 3. There was no sensible way of testing named constructors throwing Exceptions (e.g. when guarding invariants)

# Describing constructors in 2.3.0

You can now describe named constructors using a shortcut syntax:

```php
$this->beConstructedNamed('Ciaran');
```

This is the equivalent of the case above, without the need to pass the arguments as an array. In short anything matching
`beConstructed*()` or `beConstructedThrough*()` are converted to an equivalent `beConstructedThrough()` call.

The aim of this is to make the specs more readable - the cost is that there is now more than one way of specifying these things.
Time will tell whether this works or not.

Another new addition is that when generating a named constructor, you will be asked:

```
Do you want me to make the constructor of CLASS private for you? [Y/n]
```

When answering yes a private `__construct` is generated, meaning the named constructor must be used to create instances of the obectk.

# Describing constructor failure in 2.2.x

Until now, it's only been possible to test a constructor that throws an exception by explicitly invoking it:

```php
$this->shouldThrow('InvalidArgumentException')->during('__construct', ['']);
```

This suffers the same problems that `beConstructedThrough` had - mostly people forgetting to put single arguments inside
an array.

It was vaguely dissatisfying that you tested the constructor by invoking it, and potentially had to repeat the arguments
again, even if you'd called `beConstructedWith`. Worse, there was no sensible way to specify a static constructor
throwing an argument.

# Describing constructor failure in 2.3.0

Thanks to [Albert](https://github.com/acasademont) we have a new syntax specifically for describing this sort of exception
that does not care what the construction method used was:

```php
$this->beConstructedWith(-100);
$this->shouldThrow('InvalidArgumentException')->duringInstantiation();
```

or

```php
$this->beConstructedNamed('InvalidName');
$this->shouldThrow('InvalidArgumentException')->duringInstantiation();
```

For me this is much clearer, and really helps with the clarity of the specs.

# One last thing...

Something that's bugged me for years is that when PhpSpec generates a constructor method it does so at the end of the
class. Thanks to [Shane](https://github.com/shanethehat) it's now placed up front in the class!

This is the sort of small change that takes a big effort to implement, so thanks Shane and all the other contributors who've
made this release great.


