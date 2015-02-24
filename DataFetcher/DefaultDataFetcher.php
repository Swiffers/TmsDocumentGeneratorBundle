<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

class DefaultDataFetcher implements DataFetcherInterface
{
    /**
     * {@inheritDoc}
     * exemple: $datum={"parameter" => $parameter}
     */
    public function fetch(array $datum){
        return $datum;
    }
}