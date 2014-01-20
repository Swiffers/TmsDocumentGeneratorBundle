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
    public function __construct($template, $generator)
    {
        parent::__construct($template, $generator);
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
