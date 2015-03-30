<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\HtmlConverter;

use Tms\Bundle\DocumentGeneratorBundle\Exception\UnexpectedTypeException;

/**
 * Class HtmlConverterRegistry
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\HtmlConverter
 */
class HtmlConverterRegistry implements HtmlConverterRegistryInterface
{
    /**
     * @var array
     */
    private $converters;

    /**
     * @var array
     */
    private $mimeTypes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->converters = array();
        $this->mimeTypes  = array();
    }

    /**
     * {@inheritDoc}
     */
    public function setHtmlConverter($alias, HtmlConverterInterface $htmlconverter)
    {
        $this->converters[$alias] = $htmlconverter;
        $this->mimeTypes[$alias] = $htmlconverter->getMimeType();

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
            throw new \InvalidArgumentException(sprintf(
                'InvalidArgumentException - Could not load html converter "%s"',
                $alias
            ));
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

    /**
     * {@inheritDoc}
     */
    public function getMimeType($alias)
    {
        return $this->mimeTypes[$alias];
    }
}