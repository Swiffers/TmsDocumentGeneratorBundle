<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\DataFetcher;

use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\ParticipationDataFetcher;

use Da\ApiClientBundle\Exception\ApiHttpResponseException;

/**
 * Class OfferDataFetcherTest
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\Tests\DataFetcher
 */
class ParticipationDataFetcherTest extends \PHPUnit_Framework_TestCase
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
                ->setMethods(array('go', 'execute'))
                ->getMock();

       $this->crawler
            ->expects($this->any())
            ->method('go')
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
            ->willReturn('participation_1');

        $data = array(
            'participation_1' => '52976d6fe63ea02c768b4567'
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
            ->willReturn('participation_2');

        $data = array(
            'participation_2.id' => '52976d6fe63ea02c768b4567'
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
            ->method('execute')
            ->will(
                $this->returnValue(array(
                    array()
                ))
            );

        $fetcher = new ParticipationDataFetcher($this->crawler);

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
            ->willReturn('address');

        $data = array("address"=>"");

        $fetcher = new ParticipationDataFetcher($this->crawler);

        $fetcher->fetch($data, $mergeTag);
    }

    /**
     * testInvalidArgumentException
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentException()
    {
        $this->crawler
            ->expects($this->once())
            ->method('execute')
            ->will(
                $this->returnValue(
                    array(),
                    array()
                )
            );

        $fetcher = new ParticipationDataFetcher($this->crawler);

        $fetcher->doFetch(array());
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
            ->method('execute')
            ->will(
                $this->throwException(
                    new ApiHttpResponseException(null, null, null, null)
                )
            );

        $fetcher = new ParticipationDataFetcher($this->crawler);

        $fetcher->doFetch(array());
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
            ->method('execute')
            ->will(
                $this->throwException(
                    new ApiHttpResponseException(null, 403, null, null)
                )
            );

        $fetcher = new ParticipationDataFetcher($this->crawler);

        $fetcher->doFetch(array());
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
            ->method('execute')
            ->will(
                $this->throwException(
                    new ApiHttpResponseException(null, 404, null, null)
                )
            );

        $fetcher = new ParticipationDataFetcher($this->crawler);

        $fetcher->doFetch(array());
    }
}
