<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag;

/**
 * Entity event
 *
 * @author Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 */
class MergeTagEvent extends Event
{
    protected $mergeTag;

    /**
     * Constructor
     *
     * @param MergeTag $mergeTag
     */
    public function __construct(MergeTag $mergeTag)
    {
        $this->mergeTag = $mergeTag;
    }

    /**
     * Get Object
     *
     * @return MergeTag
     */
    public function getMergeTag()
    {
        return $this->mergeTag;
    }
}
