<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Manager;

use Tms\Bundle\DocumentGeneratorBundle\Event\ConfigurationTagEvent;
use Tms\Bundle\DocumentGeneratorBundle\Event\ConfigurationTagEvents;

/**
 * Entity manager
 *
 * @author Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 */
class ConfigurationTagManager extends AbstractManager
{
    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return "TmsDocumentGeneratorBundle:ConfigurationTag";
    }

    /**
     * {@inheritdoc}
     */
    public function add($entity)
    {
        $this->getEventDispatcher()->dispatch(
            ConfigurationTagEvents::PRE_CREATE,
            new ConfigurationTagEvent($entity)
        );

        parent::add($entity);

        $this->getEventDispatcher()->dispatch(
            ConfigurationTagEvents::POST_CREATE,
            new ConfigurationTagEvent($entity)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function update($entity)
    {
        $this->getEventDispatcher()->dispatch(
            ConfigurationTagEvents::PRE_UPDATE,
            new ConfigurationTagEvent($entity)
        );

        parent::update($entity);

        $this->getEventDispatcher()->dispatch(
            ConfigurationTagEvents::POST_UPDATE,
            new ConfigurationTagEvent($entity)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function delete($entity)
    {
        $this->getEventDispatcher()->dispatch(
            ConfigurationTagEvents::PRE_DELETE,
            new ConfigurationTagEvent($entity)
        );

        parent::delete($entity);

        $this->getEventDispatcher()->dispatch(
            ConfigurationTagEvents::POST_DELETE,
            new ConfigurationTagEvent($entity)
        );
    }
}
