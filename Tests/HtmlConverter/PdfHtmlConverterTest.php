<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\HtmlConverter;

use Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\PdfHtmlConverter;

/**
 * Class PdfHtmlConverterTest
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\Tests\HtmlConverter
 */
class PdfHtmlConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * testConvert
     *
     * @return pdfHtmlConverter
     */
    public function testConvert()
    {
        $html = '<html></html>';

        $wkhtmltopdf =
            $this->getMockBuilder('Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator')
                ->disableOriginalConstructor()
                ->getMock();

        $wkhtmltopdf
            ->expects($this->once())
            ->method('getOutputFromHtml')
            ->will($this->returnValue($html));

        $pdfHtmlConverter = new PdfHtmlConverter($wkhtmltopdf);

        $this->assertEquals($html, $pdfHtmlConverter->convert($html));

        return $pdfHtmlConverter;
    }

    /**
     * testGetMimeType
     *
     * @param PdfHtmlConverter $pdfHtmlConverter
     *
     * @depends testConvert
     */
    public function testGetMimeType(PdfHtmlConverter $pdfHtmlConverter)
    {
        $this->assertEquals('application/pdf', $pdfHtmlConverter->getMimeType());
    }
}
