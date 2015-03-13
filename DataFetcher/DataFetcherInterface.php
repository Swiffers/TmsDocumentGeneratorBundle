<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

use Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag;

interface DataFetcherInterface
{
    /**
     * Fetch.
     *
     * @param  array    $data     The data used as the fetcher source to look at.
     * @param  MergeTag $mergeTag Use information(identifier, required, defaultValue) of mergeTag to fetch data
     *
     * @return mixed
     *
     * @throws \UnexpectedValueException The identifier of merge tag were not found but is required
     */
    public function fetch(array $data, MergeTag $mergeTag);
}