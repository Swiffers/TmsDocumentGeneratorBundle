<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\HtmlConverter;

use Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\PdfHtmlConverter;

/**
 * Description of PdfHtmlConverterTest
 *
 * @author Antoine Ribola <antoine.ribola@gmail.com>
 */
class PdfHtmlConverterTest extends \PHPUnit_Framework_TestCase
{
    public function getData()
    {
        $data = array();
        
        #0
        $html = null;
        $expectedPdf = null;
        
        $data[] = array(
            $html,
            $expectedPdf
        );
        
        return $data;
    }

    /**
     * @dataProvider getData
     * @covers PdfHtmlConverter::convert
     */
    public function testConvert($html,$expectedPdf)
    {
        $pdfHtmlConverter = new PdfHtmlConverter();
        
        //Correct html string
        $pdf = $pdfHtmlConverter->convert($html);
        $this->assertEquals($expectedPdf, $pdf);
    }
    
    /**
     * @covers PdfHtmlConverter::convert
     * @expectedException UnexpectedTypeException
     */
    public function testUnexpectedTypeException()
    {
        $pdfHtmlConverter = new PdfHtmlConverter();
        
        //no string param
        $pdf = $pdfHtmlConverter->convert(00000);
    }
}
