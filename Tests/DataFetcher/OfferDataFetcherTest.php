<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\DataFetcher;

use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\OfferDataFetcher;

use Da\ApiClientBundle\Exception\ApiHttpResponseException;

/**
 * Class OfferDataFetcherTest
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\Tests\DataFetcher
 */
class OfferDataFetcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $crawler
     */
    protected $crawler;

    /**
     * setUpBeforeClass
     */
    public function setUp()
    {
        $this->crawler =
            $this->getMockBuilder('Tms\Bundle\RestClientBundle\Hypermedia\Crawling\Crawler')
                ->disableOriginalConstructor()
                ->setMethods(array('go', 'findOne', 'getData'))
                ->getMock();

        $this->crawler
            ->expects($this->any())
            ->method('go')
            ->will($this->returnSelf());

        $this->crawler
            ->expects($this->any())
            ->method('findOne')
            ->will($this->returnSelf());
    }

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
            ->willReturn('offer_1');

        $data = array(
            'offer_1' => 'msdata-123'
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
            ->willReturn('offer_2');

        $data = array(
            'offer_2.reference' => 'msdata-456'
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
        $this->crawler
            ->expects($this->once())
            ->method('getData')
            ->will(
                $this->returnValue(
                    array()
                )
            );

        $fetcher = new OfferDataFetcher($this->crawler);

        $this->assertEquals(array(), $fetcher->Fetch($data, $mergeTag));
    }

    /**
     * testMissingGenerationParametersException
     *
     * @expectedException \Tms\Bundle\DocumentGeneratorBundle\Exception\MissingGenerationParametersException
     */
    public function testMissingGenerationParametersException()
    {
        $mergeTag = $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag')
            ->disableOriginalConstructor()
            ->getMock();
        $mergeTag
            ->expects($this->once())
            ->method('getIdentifier')
            ->willReturn('offer_3');

        $data = array("offer_3"=>"");

        $fetcher = new OfferDataFetcher($this->crawler);

        $fetcher->fetch($data, $mergeTag);
    }


    /**
     * testApiHttpResponseException
     *
     * @expectedException \Da\ApiClientBundle\Exception\ApiHttpResponseException
     */
    public function testApiHttpResponseException()
    {
        $this->crawler
            ->expects($this->once())
            ->method('getData')
            ->will(
                $this->throwException(
                    new ApiHttpResponseException(null, null, null, null)
                )
            );

        $fetcher = new OfferDataFetcher($this->crawler);

        $fetcher->doFetch(array('reference'=>'msdata-789'));
    }

    /**
     * testAccessDeniedHttpException
     *
     * @expectedException \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function testAccessDeniedHttpException()
    {
        $this->crawler
            ->expects($this->once())
            ->method('getData')
            ->will(
                $this->throwException(
                    new ApiHttpResponseException(null, 403, null, null)
                )
            );

        $fetcher = new OfferDataFetcher($this->crawler);

        $fetcher->doFetch(array('reference'=>'msdata-789'));
    }

    /**
     * testNotFoundHttpException
     *
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testNotFoundHttpException()
    {
        $this->crawler
            ->expects($this->once())
            ->method('getData')
            ->will(
                $this->throwException(
                    new ApiHttpResponseException(null, 404, null, null)
                )
            );

        $fetcher = new OfferDataFetcher($this->crawler);

        $fetcher->doFetch(array('reference'=>'msdata-789'));
    }
}
