#TmsDocumentGeneratorBundle

##Installation

### Step 1: Composer

First, add these dependencies in your `composer.json` file:

```json
"repositories": [
    ...,
    {
        "type": "vcs",
        "url": "https://github.com/Tessi-Tms/TmsDocumentGeneratorBundle.git"
    }
],
"require": {
        ...,
        "tms/participation-client-bundle": "dev-master"
    },
```

Then, retrieve the bundles with the command:

```sh
composer update      # WIN
composer.phar update # LINUX
```

### Step 3: Kernel

Enable the bundles in your application kernel:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Tms\Bundle\DocumentGeneratorBundle\TmsDocumentGeneratorBundle(),
    );
}
```

### Step 4: Configuration

You can simply add the default participation configuration. For this import the config.yml file

``` yaml
# app/config/config.yml
    - { resource: @TmsDocumentGeneratorBundle/Resources/config/config.yml }
```


Documentation
-------------

Check the [documentation](https://github.com/Tessi-Tms/TmsDocumentGeneratorBundle/blob/fetcher/Resources/doc) to learn more about the API provided by this bundle.

Tests
-----

To execute unit tests:
```sh
$ phpunit -c .
```

To generate a coverage report:
```sh
$ phpunit --coverage-html ../Resource/doc/Coverage .
```
