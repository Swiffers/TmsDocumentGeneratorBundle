<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

interface DataFetcherRegistyInterface
{
    /**
     * {@inheritDoc}
     */
    public function setDataFetcher(string $format,DataFetcherInterface $datafetcher){

    }

    /**
     * {@inheritDoc}
     */
    public function getDataFetcher(string $alias){

    }

    /**
     * {@inheritDoc}
     */
    public function hasDataFetcher(string $alias){
        
    }
}