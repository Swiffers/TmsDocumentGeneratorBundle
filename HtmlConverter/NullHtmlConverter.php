<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\HtmlConverter;


class NullHtmlConverter implements HtmlConverterInterface
{
    /**
     * {@inheritDoc}
     */
    public function convert($html)
    {
        return $html;
    }
}