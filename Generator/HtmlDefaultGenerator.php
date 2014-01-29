<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Generator;

class HtmlDefaultGenerator implements GeneratorInterface
{
    /**
     * {@inheritDoc}
     */
    public function generate($html)
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