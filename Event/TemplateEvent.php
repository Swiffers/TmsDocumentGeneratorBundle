<?php
namespace Tms\Bundle\DocumentGeneratorBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

/**
 * Description of TemplateEvent
 *
 * @author Linok
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
