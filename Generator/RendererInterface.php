<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Generator;

interface RendererInterface
{
    /**
     * Deliver a document in the proper format
     *
     * @return text
     */
    public function render();
}