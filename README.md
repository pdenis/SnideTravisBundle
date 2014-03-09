SnideTravisBundle
======================

A quick overview of travis CI builds of your repository (Symfony 2 Bundle)

[![Build Status](https://travis-ci.org/pdenis/SnideTravisBundle.png)](https://travis-ci.org/pdenis/SnideTravisBundle)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/pdenis/SnideTravisBundle/badges/quality-score.png?s=f710c1255d1bd67ad1579f47dec413e0174c359e)](https://scrutinizer-ci.com/g/pdenis/SnideTravisBundle/)

# Setup
-----

## Installation by Composer

If you use composer, add SnideTravisBundle bundle as a dependency to the composer.json of your application

```php
    "require": {
        ...
        "snide/travis-bundle": "dev-master"
        ...
    },

## Loading

Add the bundle to your app/AppKernel.php under the dev environment
```php
if (in_array($this->getEnvironment(), array('dev', 'test'))) {
    ...
    $bundles[] = new Snide\Bundle\TravisBundle\SnideTravisBundle();
}
```
The bundle needs to copy the resources necessary to the web folder. You can use the command below:

```bash
    php app/console assets:install
```

## Configuration

Add SnideTravisBundle following to your `app/config/config_dev.yml` (you only want to use this in the dev environment)

```yml
snide_travis:
    repository:
        slug: pdenis/SnideTravinizerBundle # your repository slug
    # Optional
    filesystem_cache_path: "%kernel.cache_dir%/travis"

```

## Overview

<img src="https://raw.github.com/pdenis/SnideTravisBundle/master/docs/screenshots/general.png" alt="Travis builds">
