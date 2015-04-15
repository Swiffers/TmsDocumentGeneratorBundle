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
            "url": "https://github.com/Tessi-Tms/TmsMediaClientBundle.git"
        },
        {
            "type": "vcs",
            "url": "https://github.com/Tessi-Tms/TmsLoggerBundle.git"
        },
        {
            "type": "vcs",
            "url": "https://github.com/Tessi-Tms/TmsRestClientBundle.git"
        },
        {
            "type": "vcs",
            "url": "https://github.com/Tessi-Tms/TmsDocumentGeneratorBundle.git"
        }
    ],
    "require": {
        ...,
        "knplabs/knp-snappy-bundle": "1.2.*",
        "idci/simple-metadata-bundle": "1.0.*",
        "tms/media-client-bundle": "1.1.*",
        "tms/logger-bundle": "1.0.*",
        "tms/rest-client-bundle": "1.0.*",
        "tms/document-generator-bundle": "dev-master"
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
        new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
        new IDCI\Bundle\SimpleMetadataBundle\IDCISimpleMetadataBundle(),
        new Tms\Bundle\LoggerBundle\TmsLoggerBundle(),
        new Tms\Bundle\MediaClientBundle\TmsMediaClientBundle(),
        new Tms\Bundle\RestClientBundle\TmsRestClientBundle(),
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
* [Configuration Reference](Resources/doc/configuration_reference.md)

Tests
-----

To execute unit tests:
```sh
$ phpunit --coverage-text
```
