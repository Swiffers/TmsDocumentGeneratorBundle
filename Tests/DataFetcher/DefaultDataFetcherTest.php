<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\DataFetcher;

use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DefaultDataFetcher;

/**
 * Description of DefaultDataFetcherTest
 *
 * @author Antoine Ribola <antoine.ribola@gmail.com>
 */
class DefaultDataFetcherTest extends \PHPUnit_Framework_TestCase
{
    public function getData()
    {
        $providedData = array();
        
        #0
        $data = array(
            "name" => "Ribola",
            "firstname" => "Antoine",
            "participation_id" => "00000"
        );
        $expectedFetchedData = $data;
        
        $providedData[] = array(
            $data,
            $expectedFetchedData
        );
        
        #1
        $data = array(
            "name" => "Shang",
            "firstname" => "Guokan"
        );
        $expectedFetchedData = $data;
            
        $providedData[] = array(
            $data,
            $expectedFetchedData
        );
        
        return $providedData;
    }
    
    /**
     * @covers DefaultDataFetcher::doFetch
     * @dataProvider getData
     */
    public function testDoFetch(array $data, array $expectedFetchedData)
    {
        $dataFetcher = new DefaultDataFetcher();
        
        $fetchedDate = $dataFetcher->doFetch($data);
        $this->assertEquals($expectedFetchedData, $fetchedDate);
    }
}
