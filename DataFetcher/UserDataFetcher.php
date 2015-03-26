<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;

use Tms\Bundle\RestClientBundle\Hypermedia\Crawling\CrawlerInterface;

class UserDataFetcher extends AbstractDataFetcher
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
    protected function configureParameters(OptionsResolverInterface $resolver)
    {
        parent::configureParameters($resolver);
        $resolver
            ->setOptional(array('_'))
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function doFetch(array $params)
    {

    }
}