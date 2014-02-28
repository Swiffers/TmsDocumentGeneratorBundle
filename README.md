TmsDocumentGeneratorBundle
==========================

Symfony2 bundle used to generate a document


Installation
------------

To install this bundle please follow these steps:

First, add the dependencies in your `composer.json` file:

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
        "tms/document-generator-bundle": "dev-master"
    },
```

Then, install the bundle with the command:

```sh
composer update
```

Finally, enable the bundle in your application kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        //
        new Tms\Bundle\DocumentGeneratorBundle\TmsDocumentGeneratorBundle(),
    );
}
```

API
---

Generate a document

/api/generate/{id}.{format}?data={data}&token={token}

Download a PDF document

/api/download/{id}/{name}.pdf?data={data}&token={token}

```
{id} is the ID of the document
{data} is a base64 stringified json
{token} is a MD5 hash
{name} is the filename you gave to the PDF document you want to download
```

Examples:

- /api/generate/1.html?data=eyJ2YXIxIjoidGVzdDEiLCJ2YXIyIjoidGVzdDIiLCJsYXN0bmFtZSI6ImNoYXRlYXUiLCJmaXJzdG5hbWUiOiJqcCJ9&token=26e84f83b15e24eaa641296d6cba3e91

- /api/download/1/test.pdf?data=eyJ2YXIxIjoidGVzdDEiLCJ2YXIyIjoidGVzdDIiLCJsYXN0bmFtZSI6ImNoYXRlYXUiLCJmaXJzdG5hbWUiOiJqcCJ9&token=26e84f83b15e24eaa641296d6cba3e91

In your dev environnement, you can get the token with that method:

/api/token/{id}.{format}?data={data}

Example:

- /api/token/34.html?data=eyJuYW1lIjoiY2hhdGVhdSJ9
