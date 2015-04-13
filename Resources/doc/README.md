#TmsDocumentGeneratorBundle Documentation

##API Reference

|API                |Method|Address                     |
|-------------------|------|----------------------------|
|Generate a document|POST  |/api/generator/{template_id}|
|Download a document|POST  |/api/download/{template_id} |
|Preview a document |POST  |/api/preview/{template_id}  |

### POST parameters example

```json
data =
{
    "address": {
        "street": "29 Rue des Tilleuls",
        "city": "Voisins-le-Bretonneux",
        "postcode": "78960"
    },
    "participation_1.id": "52976d6fe63ea02c768b4567",
    "participation_2.id": "52976d70e63ea02c768b4568",
    "offer_1.reference": "msdata-1748"
}

options = 
{
    "format": "html"
}
```

