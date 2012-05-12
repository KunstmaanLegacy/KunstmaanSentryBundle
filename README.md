SentryBundle for Symfony2
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
    git=git@github.com:Kunstmaan/raven-php.git
    target=/bundles/Kunstmaan/SentryBundle/vendor/raven-php
```

*app/autoload.php*

```
$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    ...
    'Kunstmaan'        => __DIR__.'/../vendor/bundles',
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
