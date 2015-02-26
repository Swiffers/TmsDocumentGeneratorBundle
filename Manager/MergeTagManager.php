<?php
namespace Tms\Bundle\DocumentGeneratorBundle\Manager;

use Tms\Bundle\DocumentGeneratorBundle\Event\MergeTagEvents;
use Tms\Bundle\DocumentGeneratorBundle\Event\MergeTagEvent;
/**
 * Description of MergeTagManager
 *
 * @author Linok
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
}
