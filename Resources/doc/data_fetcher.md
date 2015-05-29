Data Fetcher
============

* [Default Fetcher](#default-fetcher)
* [Offer Fetcher](#offer-fetcher)
* [Operation Fetcher](#operation-fetcher)
* [Participation Fetcher](#participation-fetcher)
* [Achieve fetched data in template](#achieve-fetched-data-in-template)
* [Default Value](#default-value)

Default Fetcher
---------------

For one merge tag ``address`` with fetcher alias ``default``,
When you post in the data ``address``,
the default fetcher will just convert it to an array as fetched data,
which should return the value like: 
```php
[address] => Array
    (
        [street] => 29 Rue des Tilleuls
        [city] => Voisins-le-Bretonneux
        [postcode] => 78960
    )
```

Offer Fetcher
-------------

For one merge tag ``offer_1`` with fetcher alias ``offer``,
When you post in the data ``offer_1`` or ``offer_1.reference``,
the offer fetcher will use the value of reference to crawl the offer information from  TmsOperationManager.
which should return the value like:
```php
[offer_1] => Array
    (
        [isAvailable] => 1
        [isParticipable] => 1
        [defaultImages] => Array
            (
                [0] => Array
                    (
                        [public_uri] => //media-manager.digifid.r.vb.sfdd78.fr/api/media/3087746855-1428592149-6353f02ee27a2cd8847ec8a6f6c04270-9375
                        [mime_type] => image/jpeg
                        [provider_name] => tms_media_client.storage_provider.tms_media
                        [provider_reference] => 3087746855-1428592149-6353f02ee27a2cd8847ec8a6f6c04270-9375
                        [extension] => jpeg
                        [created_at] => 2015-04-09T17:09:09+0200
                        [updated_at] => 2015-04-09T17:09:09+0200
                    )

            )

        [operationReference] => msdata-18178
        [id] => 1614
        [reference] => msdata-1748
        [name] => ODR ACCESSOIRES HOME BY SFR
        [shortDescription] => ODR ACCESSOIRES HOME BY SFR
        [longDescription] => Offre de remboursement "Accessoires Home by SFR" entre le 10/04/15 et le 27/04/15 inclus.
        [benefitDescription] => 15 rembours par acces
        [startsAt] => 2015-04-10T00:00:00+0200
        [endsAt] => 2015-04-27T23:59:59+0200
        [participationEndsAt] => 2015-05-27T23:59:59+0200
        [complaintEndsAt] => 2015-07-27T23:59:59+0200
        [status] => NEW
        [products] => Array
            (
                [0] => Array
                    (
                        [id] => 661
                        [name] => Accessoire Home by SFR
                        [gtin] => 
                        [gtinName] => EAN
                        [shortDescription] => 
                        [longDescription] => 
                        [enabled] => 1
                        [purchasable] => 
                        [images] => Array
                            (
                                [0] => Array
                                    (
                                        [public_uri] => //media-manager.digifid.r.vb.sfdd78.fr/api/media/3087746855-1428592149-6353f02ee27a2cd8847ec8a6f6c04270-9375
                                        [mime_type] => image/jpeg
                                        [provider_name] => tms_media_client.storage_provider.tms_media
                                        [provider_reference] => 3087746855-1428592149-6353f02ee27a2cd8847ec8a6f6c04270-9375
                                        [extension] => jpeg
                                        [created_at] => 2015-04-09T17:09:09+0200
                                        [updated_at] => 2015-04-09T17:09:09+0200
                                    )

                            )

                        [metadatas] => Array
                            (
                                [0] => Array
                                    (
                                        [id] => 2121
                                        [namespace] => features
                                        [key] => Das
                                        [value] => 0
                                        [hash] => 2662977d22e4da8395ac65d1029a3028
                                        [objectClassName] => Tms\Bundle\OperationBundle\Entity\Product
                                        [objectId] => 661
                                    )

                            )

                        [createdAt] => 2015-04-09T17:09:09+0200
                        [updatedAt] => 2015-04-09T17:09:13+0200
                    )

            )

        [images] => Array
            (
            )

        [metadatas] => Array
            (
                [0] => Array
                    (
                        [id] => 2122
                        [namespace] => additional_information
                        [key] => exclusivit Boutique
                        [value] => Excluvivement en Espace SFR
                        [hash] => aff8b9c883f4d03b3f157935fcfd86c2
                        [objectClassName] => Tms\Bundle\OperationBundle\Entity\Offer
                        [objectId] => 1614
                    )

            )

        [modality] => Array
            (
                [id] => 1561
                [description] => 
                [information] => 
                [terms] =>
                [documents] => Array
                    (
                        [0] => Array
                            (
                                [public_uri] => //media-manager.digifid.r.vb.sfdd78.fr/api/media/3087746855-1428592153-3c0b95ba81c5bd93561760072b9ced19-4130
                                [mime_type] => application/pdf
                                [provider_name] => tms_media_client.storage_provider.tms_media
                                [provider_reference] => 3087746855-1428592153-3c0b95ba81c5bd93561760072b9ced19-4130
                                [extension] => pdf
                                [created_at] => 2015-04-09T17:09:13+0200
                                [updated_at] => 2015-04-09T17:09:13+0200
                            )

                    )

                [createdAt] => 2015-04-09T17:09:13+0200
                [updatedAt] => 2015-04-09T17:16:51+0200
            )

        [participation] => Array
            (
                [id] => 1492
                [webChannelEnabled] => 
                [mailChannelEnabled] => 1
                [previewBallotEnabled] => 
                [ballot] => Array
                    (
                        [public_uri] => //media-manager.digifid.r.vb.sfdd78.fr/api/media/3087746855-1428592154-3c0b95ba81c5bd93561760072b9ced19-3078
                        [mime_type] => application/pdf
                        [provider_name] => tms_media_client.storage_provider.tms_media
                        [provider_reference] => 3087746855-1428592154-3c0b95ba81c5bd93561760072b9ced19-3078
                        [extension] => pdf
                        [created_at] => 2015-04-09T17:09:13+0200
                        [updated_at] => 2015-04-09T17:09:13+0200
                    )

                [participationSteps] => 
                [steps] => Array
                    (
                    )

                [benefits] => Array
                    (
                    )

                [eligibilities] => Array
                    (
                    )

                [createdAt] => 2015-04-09T17:09:14+0200
                [updatedAt] => 2015-04-09T17:09:14+0200
            )

        [benefits] => Array
            (
            )

        [createdAt] => 2015-04-09T17:09:12+0200
        [updatedAt] => 2015-04-09T17:09:12+0200
    )
```

operation Fetcher
-----------------

For one merge tag ``operation_1`` with fetcher alias ``operation``,
When you post in the data ``operation_1`` or ``operation_1.reference``,
the operation fetcher will use the value of reference to crawl the operation information from  TmsOperationManager.
which should return the value like:
```php
Array
(
    [defaultImages] => Array
        (
            [0] => Array
                (
                    [public_uri] => //media-manager.digifid.fr/api/media/2005353137-1404208547-68c623a441e6100c41b7f954b98d9fe3-4607
                    [mime_type] => image/png
                    [provider_name] => tms_media_client.storage_provider.tms_media
                    [provider_reference] => 2005353137-1404208547-68c623a441e6100c41b7f954b98d9fe3-4607
                    [extension] => png
                    [created_at] => 2014-07-01T11:55:47+0200
                    [updated_at] => 2014-07-01T11:55:47+0200
                )

        )

    [id] => 797
    [reference] => msdata-18178
    [customerReference] => 000051#18178#3913
    [name] => ODR ACCESSOIRES HOME BY SFR
    [startsAt] => 2015-04-10T00:00:00+0200
    [endsAt] => 2015-04-27T00:00:00+0200
    [images] => Array
        (
        )

    [operationInsurances] => Array
        (
        )

    [createdAt] => 2015-04-09T17:09:12+0200
    [updatedAt] => 2015-04-09T17:09:12+0200
)
```

Participation Fetcher
---------------------

For one merge tag ``participation_1`` with fetcher alias ``participation``,
When you post in the data ``participation_1`` or ``participation_1.id``,
the participation fetcher will use the value of id to crawl the participation information from  TmsParticipationManager.
which should return the value like:

```php
[participation_1] => Array
    (
        [id] => 52976d6fe63ea02c768b4567
        [status] => compliant
        [processing_state] => C
        [created_at] => 2009-12-17T12:54:42+0100
        [updated_at] => 2013-11-26T16:29:56+0100
        [eligible_at] => 2009-12-17T12:54:42+0100
        [source] => msdata
        [customer] => SFR
        [user] => Array
            (
                [gender] => female
                [firstName] => xxxxx
                [lastName] => xxxxx
            )

        [operation] => msdata-11514
        [offer] => msdata-421
        [raw_data] => Array
            (
                [identity_gender] => female
                [identity_firstName] => 
                [identity_lastName] => 
                [identity_address1] => 
                [identity_address2] => 
                [identity_address3] => PLACE FRANCIS JAMMES
                [identity_address4] => 
                [identity_zipCode] => 78711
                [identity_city] => MANTES LA VILLE
                [identity_countryCode] => FR
                [identity_email] => email@example.fr
                [bank_accountRib] => xxxxxxxxxxxxxxx
                [purchase-1_mobilePhone] => xxxxxxxxxxxxxx
                [purchase-1_date] => 2009-10-11T00:00:00+0000
                [source_msDataRef] => 48097560
                [source_participationDate] => 2009-12-17T11:54:42+0000
            )

        [raw_controls] => Array
            (
            )

        [raw_eligibility] => Array
            (
            )

        [raw_benefit] => Array
            (
                [benefits] => Array
                    (
                        [0] => Array
                            (
                                [id] => -1
                                [category] => money
                                [deliveryMethod] => transfer
                                [unit] => euro
                                [unitScale] => 100
                                [quantity] => 10000
                                [raw] => Array
                                    (
                                        [shortDescription] => un remboursement par virement bancaire
                                        [quantity] => 1
                                        [msDataCode] => 0003
                                    )

                            )

                    )

                [history] => Array
                    (
                        [0] => Array
                            (
                                [id] => -1
                                [processingState] => C
                                [date] => 2009-12-28T00:00:00+0000
                            )

                    )

            )

        [search] => Array
            (
                [identity_gender] => female
                [identity_firstName] => xxxxx
                [identity_lastName] => xxxxx
                [identity_zipCode] => 78711
                [purchase-1_mobilePhone] => xxxxxxx
                [source_msDataRef] => 48097560
            )

        [manual_updated_at] => 
    )
```

Achieve fetched data in template
--------------------------------

For fetched data:
```php
[address] => Array
    (
        [street] => 29 Rue des Tilleuls
        [city] => Voisins-le-Bretonneux
        [postcode] => 78960
    )
```

You can used it in the template html with this way:

```
{{ address.street }}
{{ address.city }}
{{ address.postcode }}

or

{% for key, value in address %}
{{key}} : {{value}}
{% endfor %}
```

Default Value
-------------

Default Value is only used for a merge tag which is not required and which was not found in the post data.
