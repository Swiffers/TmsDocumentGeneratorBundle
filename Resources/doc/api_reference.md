API Reference
=============

|API                |Method      |Address                     |
|-------------------|------------|----------------------------|
|Generate a document|GET / POST  |/api/generate/{template_id} |
|Download a document|GET / POST  |/api/download/{template_id} |
|Preview a document |GET / POST  |/api/preview/{template_id}  |

POST Parameters
---------------

|Key    |Description|Value Format|
|-------|-----------|------------|
|data   |The data (parameters used by fetcher to fetch data for each merge tag of the template)|JSON|
|options|The generation options (format)|JSON|

```json
data =
{
    "address": {
        "street": "29 Rue des Tilleuls",
        "city": "Voisins-le-Bretonneux",
        "postcode": "78960"
    },
    "email":"email@example.com",
    "participation_1.id": "52976d6fe63ea02c768b4567",
    "participation_2.id": "52976d70e63ea02c768b4568",
    "offer_1.reference": "msdata-1748"
}

options = 
{
    "format": "html"
}
```

Formats supported
----------------

|alias|MimeType       |
|-----|---------------|
|html |text/html      |
|pdf  |application/pdf|

REST API Reference
------------------

|REST                   |Method |Address                          |
|-----------------------|-------|---------------------------------|
|Get a list of Templates|GET    |/api/templates?{filter condition}|
|Get one Template       |GET    |/api/templates/{template_id}     |

Example of filter by two tags (please merge this [branch fix-1](https://github.com/Tessi-Tms/TmsRestBundle/compare/fix-1) of TmsRestBundle first):
/api/templates?tags[0][key]=customer&tags[0][value]=orangeouest&tags[1][key]=type&tags[1][value]=email
