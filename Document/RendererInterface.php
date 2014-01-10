<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Document;

interface RendererInterface
{
    /**
     * Render a document with the given parameters
     *
     * @param array $parameters
     * @return text
     */
    public function render(array $parameters);
}