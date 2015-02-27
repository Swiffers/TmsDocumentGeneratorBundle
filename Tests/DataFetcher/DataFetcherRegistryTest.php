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
    public function testGetDataFetcher(){
        $dataFetcherRegistry = new DataFetcherRegistry();
        
        //valid alias test
        $dataFetcher = $dataFetcherRegistry->getDataFetcher(null);
        $this->assertEquals(null,$dataFetcher);
    }
    
    /**
     * @expectedException UnexpectedTypeException
     */
    public function testUnexpectedTypeException(){
        $dataFetcherRegistry = new DataFetcherRegistry();
        
        //parameter with another type than string
        $dataFetcher = $dataFetcherRegistry->getDataFetcher(0);
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentException(){
        $dataFetcherRegistry = new DataFetcherRegistry();
        
        //parameter with alias which not exist
        $dataFetcher = $dataFetcherRegistry->getDataFetcher(null);
    }
}
