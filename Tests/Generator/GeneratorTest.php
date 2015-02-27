<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\Generator;

use Tms\Bundle\DocumentGeneratorBundle\Generator\Generator;
use Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterRegistry;
use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistry;

/**
 * Description of GeneratorTest
 *
 * @author Antoine Ribola <antoine.ribola@gmail.com>
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase {
    /*
     * Need to define all test values !
     */
    
    /**
     * @dataProvider generateProvider
     */
    public function testGenerate($template_id, array $data, array $options)
    {
        $generator = new Generator(
            new HtmlConverterRegistry(),
            new DataFetcherRegistry()
        );
        
        $document = $generator->generate($template_id, $data);
        $this->assertEquals($expectedDocument, $document);
    }
    
    /**
     * testGenerate params provider
     */
    public function generateProvider()
    {
        return array(
            array(null,null,null), //test : id + all data + no option
            array(null,null,null), //test : id + fetcher needed + no option
            array(null,null,array("_format"=>"application/pdf")), //test : pdf format
            array(null,null,array("_format"=>"text/html")) //test : html format
        );
    }
    
    /**
     * @expectedException MissingDataException
     */
    public function testMissingDataException(){
        $generator = new Generator(
            new HtmlConverterRegistry(),
            new DataFetcherRegistry()
        );
        
        //Constructor without data, useful ?
        $generator->generate($template_id);
        
        //Case with empty data => generate exception ?
        $generator->generate($template_id, array());
    }
    
    /**
     * @expectedException TemplateNotFound
     */
    public function testTemplateNotFound()
    {
        $generator = new Generator(
            new HtmlConverterRegistry(),
            new DataFetcherRegistry()
        );
        
        //Id which not exist
        $generator->generate(null, null, null);
    }
}
