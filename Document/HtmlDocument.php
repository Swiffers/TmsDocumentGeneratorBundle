<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Document;

class HtmlDocument extends AbstractDomDocument
{
    /**
     * {@inheritDoc}
     */
    public function __construct($html, $css, $mergeTags, $generator)
    {
        parent::__construct($html, $css, $mergeTags, $generator);
    }

    /**
     * {@inheritDoc}
     */
    public function render(array $parameters)
    {
        $html = $this->renderDom($parameters);

        $this->generator->generateFromHtml($html);
        return $this->generator->render();
    }
}
