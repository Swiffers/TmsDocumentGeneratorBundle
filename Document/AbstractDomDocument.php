<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Document;

use Tms\Bundle\DocumentGeneratorBundle\Generator\GeneratorInterface;

abstract class AbstractDomDocument implements RendererInterface
{
    protected $source;    // DOM source code
    protected $generator; // Generator service used to generate the document

    /**
     * Constructor
     *
     * @param text $source
     * @param GeneratorInterface $generator
     */
    public function __construct($source, GeneratorInterface $generator)
    {
        $this->source = $source;
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
        $body = str_replace($identifiers, $values, $this->source);

        return $body;
    }
}
