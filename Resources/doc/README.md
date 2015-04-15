#TmsDocumentGeneratorBundle Documentation



###Barcode

For the format of participation id, for example: 52976d6fe63ea02c768b4567,
there are four standards possible:

Code 128

{{ barcode1d('Code 128', participation_1.id, 1.5) }}

PDF417

{{ barcode2d('PDF417', participation_1.id, 2, 2) }}

QR CODE

{{ barcode2d('QR CODE', participation_1.id) }}

Data Matrix

{{ barcode2d('Data Matrix', participation_1.id) }}

![barcode](https://github.com/Tessi-Tms/TmsDocumentGeneratorBundle/blob/fetcher/Resources/doc/barcode.png)

more information of barcode, please visit: https://github.com/Tessi-Tms/TmsBarcodeBundle
