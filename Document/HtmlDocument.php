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
    public function display(array $parameters)
    {
        $html = $this->renderDom($parameters);

        return $this->generator->generate($html);
    }
}
