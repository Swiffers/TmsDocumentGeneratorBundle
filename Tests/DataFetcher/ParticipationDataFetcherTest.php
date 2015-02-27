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
    /**
     * @dataProvider doFetchProvider
     */
    public function testDoFetch(array $data){
        $dataFetcher = new ParticipationDataFetcher(new Crawler());
        
        $fetchedDate = $dataFetcher->doFetch($data);
        $this->assertEquals($fetchedDate, null);
    }
    
    /**
     * data provider for testDoFetch method
     */
    public function doFetchProvider()
    {
        return array(
            array("participation_id" => null, "firstname" => "Antoine")
        );
    }
    
    /**
     * @expectedException NotFoundHttpException
     */
    public function testNotFoundHttpException(){
        $dataFetcher = new ParticipationDataFetcher(new Crawler());
        
        $fetchedDate = $dataFetcher->doFetch(null);
    }
}
