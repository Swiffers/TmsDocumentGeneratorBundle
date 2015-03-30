<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;
use Tms\Bundle\RestClientBundle\Hypermedia\Crawling\CrawlerInterface;
use Tms\Bundle\DocumentGeneratorBundle\Handler\JsonHandler;

use Da\ApiClientBundle\Exception\ApiHttpResponseException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ParticipationDataFetcher
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\DataFetcher
 */
class ParticipationDataFetcher extends AbstractDataFetcher
{
    /**
     * @var CrawlerInterface
     */
    protected $crawler;

    /**
     * Constructor
     *
     * @param CrawlerInterface $crawler
     */
    public function __construct(CrawlerInterface $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * {@inheritDoc}
     *
     * @throw AccessDeniedHttpException previous: ApiHttpResponseException
     *                                  Exception of TmsRestClientBundle
     * @throw NotFoundHttpException     previous: ApiHttpResponseException
     *                                  Exception of TmsRestClientBundle
     * @throw \InvalidArgumentException when crawler didn't return one item
     */
    public function doFetch(array $parameters)
    {
        try {
            $rawfetchedData = $this->crawler
                ->go('participation')
                ->execute(
                    sprintf('/participations'),
                    'GET',
                    $parameters
                );
        } catch (ApiHttpResponseException $e) {
            switch ($e->getHttpCode()) {
                case 403:
                    throw new AccessDeniedHttpException(sprintf(
                        "AccessDeniedHttpException - Fetcher: %s",
                        'participation'
                    ));
                case 404:
                    throw new NotFoundHttpException(sprintf(
                        "NotFoundHttpException - Fetcher: %s",
                        'participation'
                    ));
            }
            throw $e;
        }

        if (count($rawfetchedData) != 1) {
            throw new \InvalidArgumentException(sprintf(
                "InvalidArgumentException - Fetcher: %s return %s results with search query: %s, which should return only one item",
                'participation',
                count($rawfetchedData),
                http_build_query($parameters)
            ));
        }

        return JsonHandler::array_decode_json_recursive(current($rawfetchedData), true);
    }

    /**
     * {@inheritDoc}
     */
    protected function configureParameters(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setOptional(array('_'))
            ->setDefaults(array(
                'id' => function (Options $options) {
                    return $options['_'];
                },
            ))
            ->setRequired(array('id'));
    }
}