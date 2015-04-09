<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\DataFetcher;

use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DefaultDataFetcher;
use Tms\Bundle\DocumentGeneratorBundle\Handler\JsonHandler;

/**
 * Class DefaultDataFetcher
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\Tests\DataFetcher
 */
class DefaultDataFetcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * getParameter
     */
    public function getParameter()
    {
        //data set #1
        $mergeTag =
            $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag')
                ->disableOriginalConstructor()
                ->getMock();
        $mergeTag
            ->expects($this->once())
            ->method('getIdentifier')
            ->willReturn('address');

        $data = array(
            'address' => 'Rue de lac, Paris'
        );

        $parameters[] = array($data, $mergeTag);

        //data set #1
        $mergeTag =
            $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag')
                ->disableOriginalConstructor()
                ->getMock();
        $mergeTag
            ->expects($this->once())
            ->method('getIdentifier')
            ->willReturn('address');

        $data = array(
            'address' => '{"street":"Rue de lac","city":"Paris"}'
        );

        $parameters[] = array($data, $mergeTag);

        return $parameters;
    }

    /**
     * testDoFetch
     *
     * @dataProvider getParameter
     */
    public function testFetch($data, $mergeTag)
    {
        $fetcher = new DefaultDataFetcher();

        JsonHandler::is_json($data['address'])
            ? $this->assertEquals(JsonHandler::decode($data['address'],true), $fetcher->Fetch($data, $mergeTag))
            : $this->assertEquals($data['address'], $fetcher->Fetch($data, $mergeTag))
            ;
    }

    /**
     * testMissingGenerationParametersException
     *
     * @expectedException \Tms\Bundle\DocumentGeneratorBundle\Exception\MissingGenerationParametersException
     */
    public function testMissingGenerationParametersException()
    {
        $mergeTag =
            $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag')
                ->disableOriginalConstructor()
                ->getMock();
        $mergeTag
            ->expects($this->once())
            ->method('getIdentifier')
            ->willReturn('address');

        $data = array("address"=>"");

        $fetcher = new DefaultDataFetcher();
        
        $fetcher->fetch($data, $mergeTag);
    }
}
