<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
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
}