<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

interface DataFetcherInterface
{
    /**
     * Fetch.
     *
     * @param array data The data used as the fetcher source to look at.
     *
     * @return array
     */
    public function fetch(array $data);

    /**
     * Returns the searched data keys.
     *
     * @return array
     */
    public function getSearchedDataKeys();
}