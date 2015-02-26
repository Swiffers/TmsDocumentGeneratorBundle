<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\Generator;

use Tms\Bundle\DocumentGeneratorBundle\Generator\Generator;
use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistry;
use Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterRegistry;

/**
 * Description of GeneratorTest
 *
 * @author Antoine Ribola <antoine.ribola@gmail.com>
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase {
    /*
     * Need to define all test values !
     */
    public function testGenerate()
    {
        $generator = new Generator(
            new HtmlConverterRegistry(),
            new DataFetcherRegistry()
        );
        
        //Default case (return pdf? html?)
        $document = $generator->generate($template_id, $data);
        $this->assertEquals($expectedDocument, $document);
        
        //Request pdf
        $document = $generator->generate($template_id, $data, array("_format"=>"pdf"));
        $this->assertEquals($expectedDocument, $document);
        
        //Request with data need to be fetch
        $document = $generator->generate($template_id, $data);
        $this->assertEquals($expectedDocument, $document);
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
        $document = $generator->generate($template_id);
        
        //Case with empty data
        $document = $generator->generate($template_id, array());
    }
    
    public function testRender()
    {
        //TO_DO
    }
}
