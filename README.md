SnideTravisBundle
======================

A quick overview of travis CI statut of your repository (Symfony 2 Bundle)

# Setup
-----

## Installation by Composer

If you use composer, add SnideTravisBundle bundle as a dependency to the composer.json of your application

```php
    "require": {
        ...
        "snide/scrutitravisnizer-bundle": "dev-master"
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

## Configuration

Add the following to your `app/config/config_dev.yml` (you only want to use this in the dev environment)

```yml
snide_travis:
    repository:
            slug: pdenis/SnideTravinizerBundle # your repository slug
    # Optional
    filesystem_cache_path: "%kernel.cache_dir%/scrutinizer"

```

## Overview
TODO