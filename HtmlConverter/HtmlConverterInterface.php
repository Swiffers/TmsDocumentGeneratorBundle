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
}