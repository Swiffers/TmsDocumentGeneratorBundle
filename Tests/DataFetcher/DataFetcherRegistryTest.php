<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\DataFetcher;

use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistry;

/**
 * Description of DataFetcherRegistryTest
 *
 * @author Antoine Ribola <antoine.ribola@gmail.com>
 */
class DataFetcherRegistryTest extends \PHPUnit_Framework_TestCase
{
    public function getData()
    {
        $data = array();
        
        #0
        $alias = ["default"];
        $service = ["tms_document_generator.fetcher.default"];
        
        $data[] = array(
            $alias,
            $service
        );
        
        #1
        $alias = ["participation"];
        $service = ["tms_document_generator.fetcher.participation"];
        
        $data[] = array(
            $alias,
            $service
        );
        
        #2
        $alias = ["user"];
        $service = ["tms_document_generator.fetcher.user"];
        
        $data[] = array(
            $alias,
            $service
        );
        
        return $data;
    }

    /**
     * @covers DataFetcherRegistry::getDataFetcher
     * @dataProvider getData
     */
    public function testGetDataFetcher($alias, $service)
    {
        $dataFetcherRegistry = new DataFetcherRegistry();
        
        $dataFetcher = $dataFetcherRegistry->getDataFetcher($alias);
        $this->assertEquals($service,$dataFetcher);
    }
    
    /**
     * @covers DataFetcherRegistry::getDataFetcher
     * @expectedException UnexpectedTypeException
     */
    public function testUnexpectedTypeException()
    {
        $dataFetcherRegistry = new DataFetcherRegistry();
        
        //parameter with another type than string
        $dataFetcher = $dataFetcherRegistry->getDataFetcher(00000);
    }
    
    /**
     * @covers DataFetcherRegistry::getDataFetcher
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentException()
    {
        $dataFetcherRegistry = new DataFetcherRegistry();
        
        //parameter with alias which not exist
        $dataFetcher = $dataFetcherRegistry->getDataFetcher("NotExistFetcher");
    }
}
