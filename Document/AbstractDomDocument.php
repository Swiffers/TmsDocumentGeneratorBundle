<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Document;

use Tms\Bundle\DocumentGeneratorBundle\Generator\GeneratorInterface;

abstract class AbstractDomDocument implements RendererInterface
{
    protected $html;      // Document
    protected $css;       // Style
    protected $generator; // Generator service used to generate the document

    /**
     * Constructor
     *
     * @param text $html
     * @param text $css
     * @param GeneratorInterface $generator
     */
    public function __construct($html, $css, GeneratorInterface $generator)
    {
        $this->html = $html;
        $this->css = $css;
        $this->generator = $generator;
    }

    /**
     * Render the DOM binded with the given parameters
     *
     * @param array $parameters
     * @return text
     */
    public function renderDom(array $parameters)
    {
        $identifiers = array();
        $values = array();
        foreach ($parameters as $identifier => $value) {
            array_push($identifiers, $identifier);
            array_push($values, $value);
        }
        $body = str_replace($identifiers, $values, $this->html);
        $body += $this->css;

        return $body;
    }
}
