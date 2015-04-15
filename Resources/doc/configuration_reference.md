Configuration Reference
=======================

Configuration
-------------

Add the default configuration. For this import the config.yml file
```yaml
# app/config/config.yml
imports:
    - { resource: @TmsDocumentGeneratorBundle/Resources/config/config.yml }
```

Routing
-------

Add the default routing. For this import the routing.yml file
```yaml
# app/config/routing.yml
tms_document_generator_bundle_api:
    resource: "@TmsDocumentGeneratorBundle/Resources/config/routing.yml"
```
