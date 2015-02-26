<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\HtmlConverter;

use Tms\Bundle\DocumentGeneratorBundle\Exception\UnexpectedTypeException;

class HtmlConverterRegistry implements HtmlConverterRegistryInterface
{
    /**
     * @var array
     */
    private $converters;

    public function __construct()
    {
        $this->converters = array();
    }

    /**
     * {@inheritDoc}
     */
    public function setHtmlConverter($alias, HtmlConverterInterface $htmlconverter)
    {
        $this->converters[$alias] = $htmlconverter;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getHtmlConverter($alias)
    {
        if (!is_string($alias)) {
            throw new UnexpectedTypeException($alias, 'string');
        }

        if (!$this->hasHtmlConverter($alias)) {
            throw new \InvalidArgumentException(sprintf('Could not load html converter "%s"', $alias));
        }

        return $this->converters[$alias];
    }

    /**
     * {@inheritDoc}
     */
    public function hasHtmlConverter($alias)
    {
        if (!isset($this->converters[$alias])) {
            return false;
        }

        return true;
    }
}