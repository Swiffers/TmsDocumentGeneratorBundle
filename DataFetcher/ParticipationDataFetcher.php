<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

use Tms\Bundle\RestClientBundle\Hypermedia\Crawling\CrawlerInterface;

use Da\ApiClientBundle\Exception\ApiHttpResponseException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     */
    public function doFetch(array $data, $identifier)
    {
        $raw = array();
        try {
            $raw = $this->crawler
                ->go('participation')
                ->execute(
                    sprintf('/participations/%s', $data[$identifier]),
                    'GET'
                )
            ;
            //var_dump($raw); die;
        } catch (ApiHttpResponseException $e) {

            switch ($e->getHttpCode()) {
                case 403:
                    throw new AccessDeniedHttpException("Fetch: AccessDeniedHttpException");
                case 404:
                    throw new NotFoundHttpException("Fetch: NotFoundHttpException");
            }

            throw $e;
        }

        return $raw;
    }
}