<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Manager;

use Tms\Bundle\DocumentGeneratorBundle\Event\MergeTagEvents;
use Tms\Bundle\DocumentGeneratorBundle\Event\MergeTagEvent;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

/**
 * Description of MergeTagManager
 *
 * @author Antoine Ribola <antoine.ribola@gmail.com>
 */
class MergeTagManager extends AbstractManager
{

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return "TmsDocumentGeneratorBundle:MergeTag";
    }

    /**
     * {@inheritdoc}
     */
    public function add($entity)
    {
        $this->getEventDispatcher()->dispatch(
            MergeTagEvents::PRE_CREATE,
            new MergeTagEvent($entity)
        );
        parent::add($entity);
        $this->getEventDispatcher()->dispatch(
            MergeTagEvents::POST_CREATE,
            new MergeTagEvent($entity)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function update($entity)
    {
        $this->getEventDispatcher()->dispatch(
            MergeTagEvents::PRE_UPDATE,
            new MergeTagEvent($entity)
        );
        parent::update($entity);
        $this->getEventDispatcher()->dispatch(
            MergeTagEvents::POST_UPDATE,
            new MergeTagEvent($entity)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function delete($entity)
    {
        $this->getEventDispatcher()->dispatch(
            MergeTagEvents::PRE_DELETE,
            new MergeTagEvent($entity)
        );
        parent::delete($entity);
        $this->getEventDispatcher()->dispatch(
            MergeTagEvents::POST_DELETE,
            new MergeTagEvent($entity)
        );
    }

    /**
     * Duplicate merge tags of template
     *
     * @param Template $template
     * @param Template $templateDuplicated
     */
    public function duplicate(Template $template, Template $templateDuplicated)
    {
        foreach ($template->getMergeTags() as $mergeTag) {
            $newMergeTag = clone $mergeTag;
            $newMergeTag->setTemplate($templateDuplicated);
            $this->add($newMergeTag);
        }
    }
}
