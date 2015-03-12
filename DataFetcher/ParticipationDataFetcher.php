<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

use Tms\Bundle\RestClientBundle\Hypermedia\Crawling\CrawlerInterface;
use Da\ApiClientBundle\Exception\ApiHttpResponseException;

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
    public function doFetch(array $data)
    {
        try {
            $raw = $this->crawler
                ->go('participation')
                ->execute(
                    sprintf('/participations/%s', $data['participation_id']),
                    'GET'
                )
            ;
            //var_dump($raw); die;
        } catch (ApiHttpResponseException $e) {
            switch ($e->getHttpCode()) {
                case 403:
                    throw new AccessDeniedHttpException();
                case 404:
                    throw new NotFoundHttpException();
            }
        }
        return $raw;
    }

    /**
     * {@inheritDoc}
     */
    public function getSearchedDataKeys()
    {
        return array('participation_id');
    }
}