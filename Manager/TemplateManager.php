<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Tms\Bundle\DocumentGeneratorBundle\Manager\MergeTagManager;

use Tms\Bundle\DocumentGeneratorBundle\Event\TemplateEvents;
use Tms\Bundle\DocumentGeneratorBundle\Event\TemplateEvent;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;
use IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata;
use Tms\Bundle\MediaClientBundle\Entity\Media;

/**
 * TemplateManager
 *
 * @author Antoine Ribola <antoine.ribola@gmail.com>
 */
class TemplateManager extends AbstractManager
{
    /**
     * @var AbstractManager
     */
    protected $mergeTagManager;

    /**
     * @param EntityManager            $entityManager
     * @param EventDispatcherInterface $eventDispatcher
     * @param MergeTagManager          $mergeTagManager
     */
    public function __construct(
        EntityManager            $entityManager,
        EventDispatcherInterface $eventDispatcher,
        MergeTagManager          $mergeTagManager
    )
    {
        parent::__construct($entityManager, $eventDispatcher);
        $this->mergeTagManager = $mergeTagManager;
    }

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

    /**
     * Duplicate the template
     *
     * @param  Template $template
     * @return Template
     */
    public function duplicate(Template $template)
    {
        //Template
        $templateDuplicated = clone $template;

        $this->add($templateDuplicated);

        //Tags
        foreach ($template->getTags() as $tag) {
            $newTag = new Metadata();
            $newTag->setNamespace($tag->getNamespace());
            $newTag->setKey($tag->getKey());
            $newTag->setValue($tag->getValue());
            $newTag->setObject($templateDuplicated);
            $newTag->setObjectClassName(get_class($templateDuplicated));
            $newTag->setObjectId($templateDuplicated->getId());

            $templateDuplicated->addTag($newTag);
        }

        //Medias
        foreach ($template->getImages() as $image) {
            $newImage = new Media();
            $newImage->setPublicUri($image->getPublicUri());
            $newImage->setMimeType($image->getMimeType());
            $newImage->setExtension($image->getExtension());
            $newImage->setProviderName($image->getProviderName());
            $newImage->setProviderReference($image->getProviderReference());
            $newImage->setProviderData($image->getProviderData());

            $templateDuplicated->addImage($newImage);
        }

        //Persist
        $this->update($templateDuplicated);

        //MergeTags
        $this->mergeTagManager->duplicate($template, $templateDuplicated);

        return $templateDuplicated;
    }
}
