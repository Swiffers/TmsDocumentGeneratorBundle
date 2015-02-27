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
    /**
     * @dataProvider doFetchProvider
     */
    public function testDoFetch(array $data){
        $dataFetcher = new DefaultDataFetcher();
        
        $fetchedDate = $dataFetcher->doFetch($data);
        $this->assertEquals($fetchedDate, $data);
    }
    
    /**
     * data provider for testDoFetch method
     */
    public function doFetchProvider(){
        return array(
            array("name" => "RIBOLA", "firstname" => "Antoine")
        );
    }
}
