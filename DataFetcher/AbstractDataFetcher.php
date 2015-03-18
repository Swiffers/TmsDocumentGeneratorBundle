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
        $identifier    = $mergeTag->getIdentifier();
        $fetchDataKeys = $mergeTag->getFetchDataKeys();
        $isRequired    = $mergeTag->getRequired();
        $defaultValue  = $mergeTag->getDefaultValue();

        $missingDataKeys = array();
        foreach ($fetchDataKeys as $fetchDataKey) {
            if (!array_key_exists($identifier.'.'.$fetchDataKey, $data)) {
                $missingDataKeys[] = $identifier.'.'.$fetchDataKey;
            }
        }

        if (isset($missingDataKeys[0])) {
            //If merge tag identifier is required, it has to be submitted in the data,
            //A default value for a merge tag who is required make no sense
            if ($isRequired) {
                throw new \UnexpectedValueException(sprintf(
                    'The following fetch Data Keys: %s were not found for merge tag: %s witch is required.',
                    join($missingDataKeys, ','),
                    $identifier
                ));
            } else {
                return $defaultValue;
            }
        }

        $params = $this->getFetchParams($data, $identifier, $fetchDataKeys);
        return $this->doFetch($params);
    }

    /**
     * @param  array  $data
     * @param  string $identifier
     * @param  array  $fetchDataKeys
     * @return array
     */
    protected function getFetchParams(array $data, $identifier, $fetchDataKeys)
    {
        $params = array();
        foreach($fetchDataKeys as $fetchDataKey){
            $params[$fetchDataKey] = $data[$identifier.'.'.$fetchDataKey];
        }

        return $params;
    }

    /**
     * Do fetch.
     *
     * @param  array  $params
     *
     * @return array
     */
    public abstract function doFetch(array $params);
}