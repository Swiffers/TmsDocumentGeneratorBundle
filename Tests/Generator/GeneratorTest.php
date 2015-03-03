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
class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function getData()
    {
        $providedData = array();
        
        #0
        $template_id = [00000];
        $data = array(
            "name" => "Ribola",
            "firstname" => "Antoine"
        );
        $options = array();
        $expectedDoc = []; //Need to complete
        
        $providedData[] = array(
            $template_id,
            $data,
            $options,
            $expectedDoc
        );
        
        #1
        $template_id = [00000];
        $data = array(
            "participation_id" => 00000,
            "user_id" => 00000
        );
        $options = array("_format" => "application/pdf");
        $expectedDoc = []; //Need to complete
        
        $providedData[] = array(
            $template_id,
            $data,
            $options,
            $expectedDoc
        );
        
        #2
        $template_id = [00000];
        $data = array(
            "participation_id" => 00000,
            "firstname" => "Antoine",
            "name" => "Ribola"
        );
        $options = array("_format" => "text/html");
        $expectedDoc = []; //Need to complete
        
        $providedData[] = array(
            $template_id,
            $data,
            $options,
            $expectedDoc
        );
        
        return $providedData;
    }
    
    
    /**
     * @covers Generator::generate
     * @dataProvider getData
     */
    public function testGenerate($template_id, array $data, array $options, $expectedDoc)
    {
        $generator = new Generator(
            new HtmlConverterRegistry(),
            new DataFetcherRegistry()
        );
        
        $document = $generator->generate($template_id, $data, $options);
        $this->assertEquals($expectedDoc, $document);
    }
    
    /**
     * @covers Generator::generate
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
     * @covers Generator::generate
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
