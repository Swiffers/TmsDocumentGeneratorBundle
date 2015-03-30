<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\HtmlConverter;

use Tms\Bundle\DocumentGeneratorBundle\Exception\UnexpectedTypeException;

/**
 * Interface HtmlConverterRegistryInterface
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\HtmlConverter
 */
interface HtmlConverterRegistryInterface
{
    /**
     * Register the htmlConverter.
     *
     * @param string                 $alias         The alias converter.
     * @param HtmlConverterInterface $htmlconverter The converter.
     *
     * @return HtmlConverterRegistryInterface
     */
    public function setHtmlConverter($alias, HtmlConverterInterface $htmlconverter);

    /**
     * Returns the htmlConverter relevant to the alias.
     *
     * @param string $alias
     *
     * @return HtmlConverterInterface
     *
     * @throws UnexpectedTypeException   when the passed alias is not a string.
     * @throws \InvalidArgumentException when the converter can not be retrieved.
     */
    public function getHtmlConverter($alias);

    /**
     * Checks the existence of htmlConverter relevant to the alias.
     *
     * @param  string $alias check the converter relevant to the alias.
     *
     * @return bool
     */
    public function hasHtmlConverter($alias);

    /**
     * Returns the Mime type relevant to the alias.
     *
     * @param  string $alias
     *
     * @return string
     */
    public function getMimeType($alias);
}