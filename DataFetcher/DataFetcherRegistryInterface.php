<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

use Tms\Bundle\DocumentGeneratorBundle\Exception\UnexpectedTypeException;

/**
 * Interface DataFetcherRegistryInterface
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\DataFetcher
 */
interface DataFetcherRegistryInterface
{
    /**
     * Register the DataFetcher.
     *
     * @param string               $alias       The fetcher alias.
     * @param DataFetcherInterface $datafetcher The DataFetcher object.
     *
     * @return DataFetcherRegistryInterface
     */
    public function setDataFetcher($alias, DataFetcherInterface $datafetcher);

    /**
     * Returns the DataFetcher relevant to the alias.
     *
     * @param string $alias The fetcher alias
     *
     * @return DataFetcherInterface
     *
     * @throws UnexpectedTypeException   when the passed alias is not a string.
     * @throws \InvalidArgumentException when the data fetcher can not be retrieved.
     */
    public function getDataFetcher($alias);

    /**
     * Checks the existence of DataFetcher relevant to the alias.
     *
     * @param  string $alias check the converter relevant to the alias.
     *
     * @return bool
     */
    public function hasDataFetcher($alias);

    /**
     * Get the alias list of DataFetchers registered.
     *
     * @return array
     */
    public function getDataFetchersAlias();
}