<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

class DataFetcherRegisty implements DataFetcherRegistyInterface
{
    /**
     * register the DataFetcher
     *
     * @param string $alias
     * @param DataFetcherInterface $datafetcher
     *
     * @return DataFetcherInterface
     */
    public function setDataFetcher(string $format,DataFetcherInterface $datafetcher);

    /**
     * get the DataFetcher relevant to the alias
     *
     * @param string $alias
     *
     * @return DataFetcherInterface
     */
    public function getDataFetcher(string $alias);

    /**
     * check the existence of DataFetcher relevant to the alias
     *
     * @param string $alias check the converter relevant to the alias
     *
     * @return bool
     */
    public function hasDataFetcher(string $alias);
}