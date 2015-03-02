<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\DataFetcher;

use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\ParticipationDataFetcher;
use Tms\Bundle\RestClientBundle\Hypermedia\Crawling\Crawler;

/**
 * Description of ParticipationDataFetcherTest
 *
 * @author Antoine Ribola <antoine.ribola@gmail.com>
 */
class ParticipationDataFetcherTest extends \PHPUnit_Framework_TestCase
{
    public function getData()
    {
        $providedData = array();
        
        #0
        $data = array(
            "participation_id" => 00000,
            "user_id" => 00000
        );
        $expectedFetchedData = array(
            //Need to complete
        );
        
        $providedData[] = array(
            $data,
            $expectedFetchedData
        );
        
        #1
        $data = array(
            "participation_id" => 00000,
            "firstname" => "Antoine",
            "name" => "Ribola"
        );
        $expectedFetchedData = array(
            //Need to complete
        );
        
        $providedData[] = array(
            $data,
            $expectedFetchedData
        );
            
        return $providedData;
    }
    
    /**
     * @covers ParticipationDataFetcher::doFetch
     * @dataProvider getData
     */
    public function testDoFetch(array $data, array $expectedFetchedData)
    {
        $dataFetcher = new ParticipationDataFetcher(new Crawler());
        
        $fetchedDate = $dataFetcher->doFetch($data);
        $this->assertEquals($expectedFetchedData, $fetchedDate);
    }
    
    /**
     * @covers ParticipationDataFetcher::doFetch
     * @expectedException NotFoundHttpException
     */
    public function testNotFoundHttpException()
    {
        $dataFetcher = new ParticipationDataFetcher(new Crawler());
        
        $fetchedDate = $dataFetcher->doFetch(null);
    }
}
