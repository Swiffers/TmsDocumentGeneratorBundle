<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\HtmlConverter;

/**
 * Class NullHtmlConverter
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\HtmlConverter
 */
class NullHtmlConverter implements HtmlConverterInterface
{
    /**
     * {@inheritDoc}
     */
    public function convert($html)
    {
        return $html;
    }

    /**
     * {@inheritDoc}
     */
    public function getMimeType()
    {
        return 'text/html';
    }
}