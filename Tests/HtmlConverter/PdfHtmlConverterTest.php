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
    public function testConvert(){
        $pdfHtmlConverter = new PdfHtmlConverter();
        
        //Correct html string
        $pdf = $pdfHtmlConverter->convert($html);
        $this->assertEquals(null, $pdf);
    }
    
    /**
     * @expectedException UnexpectedTypeException
     */
    public function testUnexpectedTypeException(){
        $pdfHtmlConverter = new PdfHtmlConverter();
        
        //no string param
        $pdf = $pdfHtmlConverter->convert(0);
    }
}
