<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\HtmlConverter;

class HtmlConverterRegistry implements HtmlConverterRegistryInterface
{
    /**
     * @var array
     */
    private $converters;

    /**
     * {@inheritDoc}
     */
    public function setHtmlConverter($format, HtmlConverterInterface $htmlconverter)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function getHtmlConverter($format)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function hasHtmlConverter($format)
    {

    }
}