<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\DataFetcher;

use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\UserDataFetcher;

/**
 * Description of UserDataFetcherTest
 *
 * @author Antoine Ribola <antoine.ribola@gmail.com>
 */
class UserDataFetcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider doFetchProvider
     */
    public function testDoFetch(array $data){
        $dataFetcher = new UserDataFetcher(new Crawler());
        
        $fetchedDate = $dataFetcher->doFetch($data);
        $this->assertEquals($fetchedDate, null);
    }
    
    /**
     * data provider for testDoFetch method
     */
    public function doFetchProvider()
    {
        return array(
            array("user_id" => null, "firstname" => "Antoine")
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
