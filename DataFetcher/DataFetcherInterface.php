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
     * @param  array data The data used as the fetcher source to look at.
     *
     * @return array
     *
     * @throws UnexpectedValueException if can not found the searched data key in the data
     */
    public function fetch(array $data);

    /**
     * Returns the searched data keys.
     *
     * @return array
     */
    public function getSearchedDataKeys();
}