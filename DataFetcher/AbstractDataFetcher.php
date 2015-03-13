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
    public function fetch(array $data, MergeTag $mergeTag)
    {
        $identifier = $mergeTag->getIdentifier();
        $isRequired = $mergeTag->getRequired();
        $defaultValue = $mergeTag->getDefaultValue();

        if (!array_key_exists($identifier, $data)) {
            //If merge tag identifier is required, it has to be submitted in the data,
            //A default value for a merge tag who is required make no sense
            if ($isRequired) {
                throw new \UnexpectedValueException(sprintf(
                    'The identifier: %s of merge tag were not found, witch is required.',
                    $identifier
                ));
            } else {
                return $defaultValue;
            }
        }

        return $this->doFetch($data, $identifier);
    }

    /**
     * Do fetch.
     *
     * @param  array  $data       The data used as the fetcher source to look at.
     * @param  string $identifier The Id or a set of data for fetching
     *
     * @return array
     */
    public abstract function doFetch(array $data, $identifier);
}