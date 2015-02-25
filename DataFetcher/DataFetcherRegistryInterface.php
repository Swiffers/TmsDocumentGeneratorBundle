<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

interface DataFetcherRegistryInterface
{
    /**
     * Register the DataFetcher.
     *
     * @param string               $alias       The fetcher alias.
     * @param DataFetcherInterface $datafetcher The DataFetcher object.
     *
     * @return DataFetcherInterface
     */
    public function setDataFetcher($alias, DataFetcherInterface $datafetcher);

    /**
     * Returns the DataFetcher relevant to the alias.
     *
     * @param string $alias
     *
     * @return DataFetcherInterface
     */
    public function getDataFetcher($alias);

    /**
     * Checks the existence of DataFetcher relevant to the alias.
     *
     * @param string $alias check the converter relevant to the alias.
     *
     * @return bool
     */
    public function hasDataFetcher($alias);
}