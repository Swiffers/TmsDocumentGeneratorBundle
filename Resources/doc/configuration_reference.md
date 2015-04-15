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