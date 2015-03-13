<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

class DefaultDataFetcher extends AbstractDataFetcher
{
    /**
     * {@inheritDoc}
     */
    public function doFetch(array $data, $identifier)
    {
        return $data[$identifier];
    }
}