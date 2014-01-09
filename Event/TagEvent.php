<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Tag;

/**
 * Entity event
 *
 * @author Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 */
class TagEvent extends Event
{
    protected $tag;

    /**
     * Constructor
     *
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get Object
     *
     * @return Tag
     */
    public function getTag()
    {
        return $this->tag;
    }
}
