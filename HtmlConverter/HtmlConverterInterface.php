<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\HtmlConverter;

interface HtmlConverterInterface
{
    /**
     * Convert html page to document.
     *
     * @param $html
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