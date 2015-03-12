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
     * @param  array   $data         The data used as the fetcher source to look at.
     * @param  boolean $isRequired   If the searched data key must be presents.
     * @param  mixed   $defaultValue The returned value if the data was not fetched.
     *
     * @return mixed
     *
     * @throws UnexpectedValueException If the data was not found but is required.
     */
    public function fetch(array $data, $isRequired = false, $defaultValue = null);

    /**
     * Returns the searched data keys.
     *
     * @return array
     */
    public function getSearchedDataKeys();
}