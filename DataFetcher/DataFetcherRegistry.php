<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

class DataFetcherRegistry implements DataFetcherRegistryInterface
{
    /**
     * @var array
     */
    private $fetchers;

    /**
     * {@inheritDoc}
     */
    public function setDataFetcher($alias, DataFetcherInterface $datafetcher)
    {
        // TODO
    }

    /**
     * {@inheritDoc}
     */
    public function getDataFetcher($alias)
    {
        // TODO
    }

    /**
     * {@inheritDoc}
     */
    public function hasDataFetcher($alias)
    {
        // TODO
    }
}