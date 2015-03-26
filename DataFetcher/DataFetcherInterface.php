<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

use Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag;

use Tms\Bundle\DocumentGeneratorBundle\Exception\MissingGenerationParametersException;

interface DataFetcherInterface
{
    /**
     * Fetch.
     *
     * @param  array    $data     The data(with parameters used by fetcher to fetch data for each merge tag of the template).
     * @param  MergeTag $mergeTag Use information(identifier, required, defaultValue, etc) of mergeTag to fetch data
     *
     * @return array
     *
     * @throws MissingGenerationParametersException For a merge tag,
     *                                              When his parameters witch is used by fetcher cannot be found in the data.
     */
    public function fetch(array $data, MergeTag $mergeTag);
}