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
     * @param string $format the supported format of converter.
     * @param HtmlConverterInterface $htmlconverter
     *
     * @return HtmlConverterInterface
     */
    public function setHtmlConverter($format, HtmlConverterInterface $htmlconverter);

    /**
     * Returns the htmlConverter relevant to the format.
     *
     * @param string $format
     *
     * @return HtmlConverterInterface
     */
    public function getHtmlConverter($format);

    /**
     * Checks the existence of htmlConverter relevant to the format.
     *
     * @param string $format check the converter relevant to the format.
     *
     * @return bool
     */
    public function hasHtmlConverter($format);
}