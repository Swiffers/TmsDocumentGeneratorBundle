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
     * @param  string $html
     *
     * @return string
     */
    public function convert(string $html);
}