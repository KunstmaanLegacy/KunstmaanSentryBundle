*IMPORTANT*: We recommend that you no longer use this bundle. Since it's inception Monolog has gotten built in Sentry support. See https://github.com/KunstmaanLegacy/KunstmaanSentryBundle/issues/18 and https://github.com/Seldaek/monolog/pull/76/files


SentryBundle for Symfony2
================================

[![Build Status](https://travis-ci.org/Kunstmaan/KunstmaanSentryBundle.png?branch=master)](http://travis-ci.org/Kunstmaan/KunstmaanSentryBundle)
[![Total Downloads](https://poser.pugx.org/kunstmaan/sentry-bundle/downloads.png)](https://packagist.org/packages/kunstmaan/sentry-bundle)
[![Latest Stable Version](https://poser.pugx.org/kunstmaan/sentry-bundle/v/stable.png)](https://packagist.org/packages/kunstmaan/sentry-bundle)
[![Analytics](https://ga-beacon.appspot.com/UA-3160735-7/Kunstmaan/KunstmaanSentryBundle)](https://github.com/igrigorik/ga-beacon)

This helps binds the [raven-php module](https://github.com/getsentry/raven-php) into a Symfony2 bundle for easy use with the framework. It will autoload an exception handler into the framework, so that all uncaught errors are sent to a [Sentry server](https://www.getsentry.com).

*Important*: This bundle is heavily inspired by [Drew Butler](https://github.com/nodrew)'s Airbrake bundle.

Installation requirements
-------------------------
You should be able to get Symfony 2.1 up and running before you can install the KunstmaanAdminBundle.

Installation instructions
-------------------------
Assuming you have installed composer.phar or composer binary:

``` bash
$ composer require kunstmaan/sentry-bundle
```

Add the KunstmaanSentryBundle to your AppKernel.php file:

```
new Kunstmaan\SentryBundle\KunstmaanSentryBundle(),
```

Multiple environments support
-----------------------------

To enable Sentry for a specific environment, add these lines to the config.yml file for the environment (ie. config_prod.yml) :

```
kunstmaan_sentry:
    enabled: true
    dsn: "http://nnn:nnn@12345.12345.12345.12345/1"
```

Note that Sentry logging is disabled by default.
