<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\Generator;

use Tms\Bundle\DocumentGeneratorBundle\Generator\Generator;

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
    
    private function getHtmlConverterRegistry()
    {
        $htmlConverterRegistry = $this
            ->getMockBuilder("Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterRegistry")
            ->setMethods(array('getHtmlConverter'))    
            ->getMock()
        ;
 
        $htmlConverterRegistry
            ->expects($this->any())
            ->method('getHtmlConverter')
            ->with(
                $this->callback(
                    function ($alias)
                    {
                        $service = null;
                    
                        switch ($alias) {
                            case "html" :
                                $service = null; //Wait service done
                                break;
                            case "pdf" :
                                $service = "tms_document_generator.converter.pdf";
                                break;
                        }
                        return $service;
                    }
                )
            );
        
        return $htmlConverterRegistry;
    }
    
    private function getDataFetcherRegistry()
    {
        $dataFetcherRegistry = $this
            ->getMockBuilder("Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistry")
            ->setMethods(array('getDataFetcher'))    
            ->getMock()
        ;
 
        $dataFetcherRegistry
            ->expects($this->any())
            ->method('getHtmlConverter')
            ->with(
                $this->callback(
                    function ($alias)
                    {
                        $service = null;
                    
                        switch ($alias) {
                            case "participation" :
                                $service = "tms_document_generator.fetcher.participation";
                                break;
                            case "user" :
                                $service = "tms_document_generator.fetcher.user";
                                break;
                            default :
                                $service = "tms_document_generator.fetcher.default";
                        }
                        return $service;
                    }
                )
            );
        
        return $dataFetcherRegistry;
    }
    
    /**
     * @covers Generator::generate
     * @dataProvider getData
     */
    public function testGenerate($template_id, array $data, array $options, $expectedDoc)
    {
        $generator = new Generator(
            $this->getHtmlConverterRegistry(),
            $this->getDataFetcherRegistry()
        );
        
        $document = $generator->generate($template_id, $data, $options);
        $this->assertEquals($expectedDoc, $document);
    }
    
    /**
     * @covers Generator::generate
     * @expectedException MissingDataException
     */
    public function testMissingDataException()
    {
        $generator = new Generator(
            $this->getHtmlConverterRegistry(),
            $this->getDataFetcherRegistry()
        );
        $template_id = 00000;
        
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
            $this->getHtmlConverterRegistry(),
            $this->getDataFetcherRegistry()
        );
        
        //Id which not exist
        $generator->generate(null, null, null);
    }
}
