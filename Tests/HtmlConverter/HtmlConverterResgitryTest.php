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
    public function getData()
    {
        $data = array();
        
        #0
        $alias = ["default"];
        $service = ["tms_document_generator.converter.html"]; //Not implemented yet !
        
        $data[] = array(
            $alias,
            $service
        );
        
        #1
        $alias = ["pdf"];
        $service = ["tms_document_generator.converter.pdf"];
        
        $data[] = array(
            $alias,
            $service
        );
        
        return $data;
    }
    
    /**
     * @dataProvider getData
     * @covers HtmlConverterRegistry::getHtmlConverter
     */
    public function testGetHtmlConverter($alias, $service)
    {
        $htmlConverterRegistry = new HtmlConverterRegistry();
        
        $htmlConverter = $htmlConverterRegistry->getHtmlConverter($alias);
        $this->assertEquals($service,$htmlConverter);
    }
    
    /**
     * @covers HtmlConverterRegistry::getHtmlConverter
     * @expectedException UnexpectedTypeException
     */
    public function testUnexpectedTypeException()
    {
        $htmlConverterRegistry = new HtmlConverterRegistry();
        
        //parameter with another type than string
        $htmlConverter = $htmlConverterRegistry->getHtmlConverter(00000);
    }
    
    /**
     * @covers HtmlConverterRegistry::getHtmlConverter
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentException()
    {
        $htmlConverterRegistry = new HtmlConverterRegistry();
        
        //parameter with alias which not exist
        $htmlConverter = $htmlConverterRegistry->getHtmlConverter(null);
    }
}
