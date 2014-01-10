<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Generator;

interface GeneratorInterface
{
    /**
     * Generate a document from HTML
     *
     * @param text $html
     * @return text
     */
    public function generateFromHtml($html);
}