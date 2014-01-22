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
     * @param string $html
     * @return string
     */
    public function generate($html);

    /**
     * Get MimeType
     *
     * @return string
     */
    public function getMimeType();
}