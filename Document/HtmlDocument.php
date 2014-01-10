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
    public function __construct($source, $generator)
    {
        parent::__construct($source, $generator);
    }

    /**
     * {@inheritDoc}
     */
    public function render(array $parameters)
    {
        $html = $this->renderDom($parameters);

        return $this->generator->generateFromHtml($html);
    }
}
