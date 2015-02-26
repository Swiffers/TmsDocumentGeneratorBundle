<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\HtmlConverter;

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
     * @throws Exception\UnexpectedTypeException if the passed alias is not a string.
     * @throws \InvalidArgumentException         if the converter can not be retrieved.
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
}