<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Manager;

use Tms\Bundle\DocumentGeneratorBundle\Entity\Tag;
use Tms\Bundle\DocumentGeneratorBundle\Event\TagEvent;
use Tms\Bundle\DocumentGeneratorBundle\Event\TagEvents;

/**
 * Entity manager
 *
 * @author Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 */
class TagManager extends AbstractManager
{
    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return "TmsDocumentGeneratorBundle:Tag";
    }

    /**
     * {@inheritdoc}
     */
    public function add($entity)
    {
        $this->getEventDispatcher()->dispatch(
            TagEvents::PRE_CREATE,
            new TagEvent($entity)
        );

        parent::add($entity);

        $this->getEventDispatcher()->dispatch(
            TagEvents::POST_CREATE,
            new TagEvent($entity)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function update($entity)
    {
        $this->getEventDispatcher()->dispatch(
            TagEvents::PRE_UPDATE,
            new TagEvent($entity)
        );

        parent::update($entity);

        $this->getEventDispatcher()->dispatch(
            TagEvents::POST_UPDATE,
            new TagEvent($entity)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function delete($entity)
    {
        $this->getEventDispatcher()->dispatch(
            TagEvents::PRE_DELETE,
            new TagEvent($entity)
        );

        parent::delete($entity);

        $this->getEventDispatcher()->dispatch(
            TagEvents::POST_DELETE,
            new TagEvent($entity)
        );
    }
}
