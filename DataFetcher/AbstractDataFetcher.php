<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

abstract class AbstractDataFetcher implements DataFetcherInterface
{
    /**
     * {@inheritDoc}
     */
    public function fetch(array $data)
    {
        foreach ($this->getSearchedDataKeys() as $key){
            if (!array_key_exists($key, $data)) {
                throw new \UnexpectedValueException(sprintf(
                    'The searched data key "%s" was not found'
                ));
            }
        }

        return $this->doFetch($data);
    }

    /**
     * Do fetch.
     *
     * @param  array data The data used as the fetcher source to look at.
     *
     * @return array
     */
    public abstract function doFetch(array $data);

    /**
     * {@inheritDoc}
     */
    public function getSearchedDataKeys()
    {
        return array();
    }
}