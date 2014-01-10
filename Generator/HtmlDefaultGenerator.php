<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Generator;

class HtmlDefaultGenerator implements GeneratorInterface, RendererInterface
{
    private $html;

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        return $this->html;
    }

    /**
     * {@inheritDoc}
     */
    public function generateFromHtml($html)
    {
        $this->html = $html;
    }
}