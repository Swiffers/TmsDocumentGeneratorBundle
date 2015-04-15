TmsDocumentGeneratorBundle
==========================

Installation
------------

Add dependencies in your `composer.json` file:
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

Install these new dependencies in your application using composer:
```sh
$ php composer.phar update
```

Register needed bundles in your application kernel:
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

Add the default participation configuration. For this import the config.yml file
```yaml
# app/config/config.yml
imports:
    - { resource: @TmsDocumentGeneratorBundle/Resources/config/config.yml }
```

Add the default participation routing. For this import the routing.yml file
```yaml
# app/config/routing.yml
tms_document_generator_bundle_api:
    resource: "@TmsDocumentGeneratorBundle/Resources/config/routing.yml"
```


Documentation
-------------

* [Introduction](Resources/doc/introduction.md)
* [Architecture](Resources/doc/class_diagram.png)
* [API Reference](Resources/doc/api_reference.md)
* [Data Fetcher](Resources/doc/data_fetcher.md)
* [Configuration reference](Resources/doc/configuration_reference.md)

Tests
-----

To execute unit tests:
```sh
$ phpunit --coverage-text
```
