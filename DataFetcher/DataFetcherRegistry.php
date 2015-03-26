<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

use Tms\Bundle\DocumentGeneratorBundle\Exception\UnexpectedTypeException;

class DataFetcherRegistry implements DataFetcherRegistryInterface
{
    /**
     * @var array
     */
    private $fetchers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fetchers = array();
    }

    /**
     * {@inheritDoc}
     */
    public function setDataFetcher($alias, DataFetcherInterface $datafetcher)
    {
        $this->fetchers[$alias] = $datafetcher;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDataFetcher($alias)
    {
        if (!is_string($alias)) {
            throw new UnexpectedTypeException($alias, 'string');
        }

        if (!$this->hasDataFetcher($alias)) {
            throw new \InvalidArgumentException(sprintf(
                'InvalidArgumentException - Could not load data fetcher "%s"',
                $alias
            ));
        }

        return $this->fetchers[$alias];
    }

    /**
     * {@inheritDoc}
     */
    public function hasDataFetcher($alias)
    {
        if (!isset($this->fetchers[$alias])){
            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getDataFetchersAlias()
    {
        return array_keys($this->fetchers);
    }
}