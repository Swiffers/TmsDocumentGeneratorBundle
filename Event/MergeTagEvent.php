<?php
namespace Tms\Bundle\DocumentGeneratorBundle\Event;

use Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag;
use Symfony\Component\EventDispatcher\Event;
/**
 * Description of MergeTagEvent
 *
 * @author Linok
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
