<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;
use Tms\Bundle\LoggerBundle\Event\LogEvents;
use Tms\Bundle\LoggerBundle\Event\LogEvent;

/**
 * Abstract manager.
 *
 * @author Gabriel Bondaz <gabriel.bondaz@idci-consulting.fr>
 */
abstract class AbstractManager
{
    protected $entityManager;
    protected $eventDispatcher;

    /**
     * Constructor
     *
     * @param EntityManager                 $entityManager
     * @param ContainerAwareEventDispatcher $eventDispatcher
     */
    public function __construct(EntityManager $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Get EntityManager
     *
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Get EventDispatcher
     *
     * @return Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * Get Repository
     *
     * @return \Doctrine\ORM\EntityManager\EntityRepository
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository($this->getEntityClass());
    }

    /**
     * Magic call
     * Triger to repository methods call
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->getRepository(), $method), $args);
    }
    
    /**
     * Add
     * Use the entity manager to add (persist) the given object
     *
     * @param object $entity
     */
    public function add($entity)
    {
        if ($entity instanceof LoggableInterface) {
            $this->getEventDispatcher()->dispatch(
                LogEvents::PRE_CREATE,
                new LogEvent($entity)
            );
        }
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        if ($entity instanceof LoggableInterface) {
            $this->getEventDispatcher()->dispatch(
                LogEvents::POST_CREATE,
                new LogEvent($entity)
            );
        }
    }
    
    /**
     * Update
     * Use the entity manager to update (persist) the given object
     *
     * @param object $entity
     */
    public function update($entity)
    {
        if($entity instanceof LoggableInterface) {
            $this->getEventDispatcher()->dispatch(
                LogEvents::PRE_UPDATE,
                new LogEvent($entity)
            );
        }
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        if($entity instanceof LoggableInterface) {
            $this->getEventDispatcher()->dispatch(
                LogEvents::POST_UPDATE,
                new LogEvent($entity)
            );
        }
    }
    
    /**
     * Delete
     * Use the entity manager to delete (remove) the given object
     *
     * @param object $entity
     */
    public function delete($entity)
    {
        if($entity instanceof LoggableInterface) {
            $this->getEventDispatcher()->dispatch(
                LogEvents::PRE_DELETE,
                new LogEvent($entity)
            );
        }
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
        if($entity instanceof LoggableInterface) {
            $this->getEventDispatcher()->dispatch(
                LogEvents::POST_DELETE,
                new LogEvent($entity)
            );
        }
    }

    /**
     * Get Entity class name
     *
     * @return string
     */
    abstract function getEntityClass();
}