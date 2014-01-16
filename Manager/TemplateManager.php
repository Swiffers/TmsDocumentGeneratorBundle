<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Manager;

use Tms\Bundle\DocumentGeneratorBundle\Event\TemplateEvent;
use Tms\Bundle\DocumentGeneratorBundle\Event\TemplateEvents;

/**
 * Entity manager
 *
 * @author Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 */
class TemplateManager extends AbstractManager
{
    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return "TmsDocumentGeneratorBundle:Template";
    }

    /**
     * {@inheritdoc}
     */
    public function add($entity)
    {
        $this->getEventDispatcher()->dispatch(
            TemplateEvents::PRE_CREATE,
            new TemplateEvent($entity)
        );

        parent::add($entity);

        $this->getEventDispatcher()->dispatch(
            TemplateEvents::POST_CREATE,
            new TemplateEvent($entity)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function update($entity)
    {
        $this->getEventDispatcher()->dispatch(
            TemplateEvents::PRE_UPDATE,
            new TemplateEvent($entity)
        );

        parent::update($entity);

        $this->getEventDispatcher()->dispatch(
            TemplateEvents::POST_UPDATE,
            new TemplateEvent($entity)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function delete($entity)
    {
        $this->getEventDispatcher()->dispatch(
            TemplateEvents::PRE_DELETE,
            new TemplateEvent($entity)
        );

        parent::delete($entity);

        $this->getEventDispatcher()->dispatch(
            TemplateEvents::POST_DELETE,
            new TemplateEvent($entity)
        );
    }
}
