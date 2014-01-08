<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Renderer;

abstract class AbstractDomDocument implements RendererInterface
{
    private $source;

    public function __construct($source)
    {
        $this->source = $source;
    }

    /**
     * Render the source binded with the parameters
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
