<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\HtmlConverter;

/**
 * Interface HtmlConverterInterface
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\HtmlConverter
 */
interface HtmlConverterInterface
{
    /**
     * Convert html page to document.
     *
     * @param string $html
     *
     * @return string
     */
    public function convert($html);

    /**
     * Get the MimeType of document converted by html converter
     *
     * @return string
     */
    public function getMimeType();
}