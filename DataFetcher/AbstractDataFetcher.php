<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

use Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag;

abstract class AbstractDataFetcher implements DataFetcherInterface
{
    /**
     * {@inheritDoc}
     */
    public function fetch(array $data, $isRequired = false, $defaultValue = null)
    {
        $missingKeys = array();
        foreach ($this->getSearchedDataKeys() as $key) {
            if (!array_key_exists($key, $data)) {
                $missingKeys[] = $key;
            }
        }

        if (isset($missingKeys[0])) {
            if (!$isRequired) {
                return $defaultValue;
            }

            throw new \UnexpectedValueException(sprintf(
                'The following keys were not found %s',
                json_encode($missingKeys)
            ));
        }

        try {
            return $this->doFetch($data);
        } catch (\Exception $e) {
            if ($isRequired) {
                throw $e;
            }

            return $defaultValue;
        }
    }

    /**
     * {@inheritDoc}
     */
    /*public function fetch(array $data, MergeTag $mergeTag)
    {
        $identifier = $mergeTag->getIdentifier();
        $isRequired = $mergeTag->getRequired();
        $defaultValue = $mergeTag->getDefaultValue();

        if (!array_key_exists($identifier, $data)) {
            if ($isRequired && is_null($defaultValue)) {
                throw new \UnexpectedValueException(sprintf(
                    'The identifier: %s of merge tag were not found, witch is requires but doesn\'t have a default value',
                    $identifier
                ));
            }
            else {
                return $defaultValue;
            }
        }

        return $this->doFetch($data);
    }*/

    /**
     * Do fetch.
     *
     * @param  array $data The data used as the fetcher source to look at.
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