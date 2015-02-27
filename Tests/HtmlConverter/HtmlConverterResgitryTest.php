<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\HtmlConverter;

use Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterRegistry;

/**
 * Description of HtmlConverterResgitryTest
 *
 * @author Antoine Ribola <antoine.ribola@gmail.com>
 */
class HtmlConverterResgitryTest extends \PHPUnit_Framework_TestCase
{

    public function testGetHtmlConverter(){
        $htmlConverterRegistry = new HtmlConverterRegistry();
        
        //valid alias test
        $htmlConverter = $htmlConverterRegistry->getHtmlConverter(null);
        
        $this->assertEquals(null,$htmlConverter);
    }
    
    /**
     * @expectedException UnexpectedTypeException
     */
    public function testUnexpectedTypeException(){
        $htmlConverterRegistry = new HtmlConverterRegistry();
        
        //parameter with another type than string
        $htmlConverter = $htmlConverterRegistry->getHtmlConverter(0);
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentException(){
        $htmlConverterRegistry = new HtmlConverterRegistry();
        
        //parameter with alias which not exist
        $htmlConverter = $htmlConverterRegistry->getHtmlConverter(null);
    }
}
