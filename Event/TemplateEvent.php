<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

/**
 * Entity event
 *
 * @author Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 */
class TemplateEvent extends Event
{
    protected $template;

    /**
     * Constructor
     *
     * @param Template $template
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Get Object
     *
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
