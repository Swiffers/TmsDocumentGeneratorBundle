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
 * Class OfferDataFetcher
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\DataFetcher
 */
class OfferDataFetcher extends AbstractDataFetcher
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
                ->go('operation')
                ->findOne('offers', $parameters['reference'])
                ->getData();
        } catch (ApiHttpResponseException $e) {
            switch ($e->getHttpCode()) {
                case 403:
                    throw new AccessDeniedHttpException(sprintf(
                        "AccessDeniedHttpException - Fetcher: %s",
                        'offer'
                    ));
                case 404:
                    throw new NotFoundHttpException(sprintf(
                        "NotFoundHttpException - Fetcher: %s",
                        'offer'
                    ));
            }
            throw $e;
        }

        return JsonHandler::array_decode_json_recursive($rawfetchedData, true);
    }

    /**
     * {@inheritDoc}
     */
    protected function configureParameters(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setOptional(array('_'))
            ->setDefaults(array(
                'reference' => function (Options $options) {
                    return $options['_'];
                },
            ))
            ->setRequired(array('reference'));
    }
}