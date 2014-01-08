<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Renderer;

class HtmlDocument extends AbstractDomDocument
{
    public function __construct($source)
    {
        parent::__construct($source);
    }

    /**
     * Render a source with the tags
     *
     * @param text $source
     * @param array $mergeTags
     * @return text
     */
    public function render(array $parameters)
    {
        return $this->renderDom($parameters);
    }
}
