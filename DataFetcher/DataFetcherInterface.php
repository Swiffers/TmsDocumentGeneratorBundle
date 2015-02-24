<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

interface DataFetcherInterface
{
    /**
     * fetch
     *
     * @param array datum
     *
     * @return array
     */
    public function fetch(array $datum);
}