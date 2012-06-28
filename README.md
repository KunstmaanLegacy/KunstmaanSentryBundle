SentryBundle for Symfony2 [![Build Status](https://secure.travis-ci.org/Kunstmaan/KunstmaanSentryBundle.png?branch=master)](http://travis-ci.org/Kunstmaan/KunstmaanSentryBundle)
================================

This helps binds the [raven-php module](https://github.com/getsentry/raven-php) into a Symfony2 bundle for easy use with the framework. It will autoload an exception handler into the framework, so that all uncaught errors are sent to a [Sentry server](https://www.getsentry.com).

*Important*: This bundle is heavily inspired by [Drew Butler](https://github.com/nodrew)'s Airbrake bundle.

Installation Instructions
=========================

Add these blocks to the following files

*deps*

```
[KunstmaanSentryBundle]
    git=git@github.com:Kunstmaan/KunstmaanSentryBundle.git
    target=/bundles/Kunstmaan/SentryBundle

[raven-php]
    git=https://github.com/getsentry/raven-php.git
    target=/raven-php
```

*app/autoload.php*

```
$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    ...
    'Kunstmaan'        => __DIR__.'/../vendor/bundles',
    ...
));
$loader->registerPrefixes(array(
    ...
    'Raven_'           => __DIR__.'/../vendor/raven-php/lib',
    ...
));
```

*app/AppKernel.php*

```
public function registerBundles()
{
    $bundles = array(
        // System Bundles
        ...
        new Kunstmaan\SentryBundle\KunstmaanSentryBundle(),
        ...
    );
}
```

*app/config/parameters.ini*

```
        sentry.dsn="[dsn]"
```

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    LICENSE
