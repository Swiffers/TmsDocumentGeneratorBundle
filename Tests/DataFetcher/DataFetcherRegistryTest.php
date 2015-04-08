<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\DataFetcher;

use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistry;

/**
 * Class DataFetcherRegistryTest
 */
class DataFetcherRegistryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return DataFetcherRegistry
     */
    public function testSetDataFetcher()
    {
        $default =
            $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DefaultDataFetcher')
                ->disableOriginalConstructor()
                ->getMock();
        $offer =
            $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\DataFetcher\OfferDataFetcher')
                ->disableOriginalConstructor()
                ->getMock();
        $participation =
            $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\DataFetcher\ParticipationDataFetcher')
                ->disableOriginalConstructor()
                ->getMock();

        $registry = new DataFetcherRegistry();

        $this->assertInstanceOf(
            'Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistryInterface',
            $registry->setDataFetcher('default', $default)
        );

        $this->assertInstanceOf(
            'Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistryInterface',
            $registry->setDataFetcher('offer', $offer)
        );

        $this->assertInstanceOf(
            'Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistryInterface',
            $registry->setDataFetcher('participation', $participation)
        );

        return $registry;
    }

    /**
     * @param DataFetcherRegistry $registry
     *
     * @depends testSetDataFetcher
     */
    public function testHasDataFetcher(DataFetcherRegistry $registry)
    {
        $this->assertTrue($registry->hasDataFetcher('default'));
        $this->assertTrue($registry->hasDataFetcher('offer'));
        $this->assertTrue($registry->hasDataFetcher('participation'));
        $this->assertFalse($registry->hasDataFetcher('user'));
    }

    /**
     * @param DataFetcherRegistry $registry
     *
     * @depends testSetDataFetcher
     */
    public function testGetDataFetcher(DataFetcherRegistry $registry)
    {
        $this->assertInstanceOf(
            'Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherInterface',
            $registry->getDataFetcher('default')
        );

        $this->assertInstanceOf(
            'Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherInterface',
            $registry->getDataFetcher('offer')
        );

        $this->assertInstanceOf(
            'Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherInterface',
            $registry->getDataFetcher('participation')
        );
    }

    /**
     * @param DataFetcherRegistry $registry
     *
     * @depends testSetDataFetcher
     */
    public function testGetDataFetchersAlias(DataFetcherRegistry $registry)
    {
        $this->assertEquals(
            array('default', 'offer', 'participation'),
            $registry->getDataFetchersAlias()
        );
    }

    /**
     * @param DataFetcherRegistry $registry
     *
     * @expectedException \Tms\Bundle\DocumentGeneratorBundle\Exception\UnexpectedTypeException
     *
     * @depends testSetDataFetcher
     */
    public function testUnexpectedTypeException(DataFetcherRegistry $registry)
    {
        $registry->getDataFetcher(array());
    }

    /**
     * @param DataFetcherRegistry $registry
     *
     * @expectedException \InvalidArgumentException
     *
     * @depends testSetDataFetcher
     */
    public function testInvalidArgumentException(DataFetcherRegistry $registry)
    {
        $registry->getDataFetcher('user');
    }
}
