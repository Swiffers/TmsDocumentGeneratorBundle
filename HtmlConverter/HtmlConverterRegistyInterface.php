<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\HtmlConverter;

interface HtmlConverterRegistyInterface
{
    /**
     * register the htmlConverter
     *
     * @param string $format the supported format of converter
     * @param HtmlConverterInterface $htmlconverter
     *
     * @return string
     */
    public function setHtmlConverter(string $format,HtmlConverterInterface $htmlconverter);

    /**
     * get the htmlConverter relevant to the format
     *
     * @param string $format
     *
     * @return string
     */
    public function getHtmlConverter(string $format);

    /**
     * check the existence of htmlConverter relevant to the format
     *
     * @param string $format check the converter relevant to the format
     *
     * @return bool
     */
    public function hasHtmlConverter(string $format);
}