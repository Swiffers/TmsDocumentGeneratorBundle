<?php

namespace Tms\Bundle\DocumentGeneratorBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Tms\Bundle\MediaClientBundle\Entity\Media;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadMediaData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        /*
        $media = new Media();
        for ($i = 1; $i <= 100; $i++) {
            $template = $this->getReference("template".$i);
            $template->addImage($media);
            $this->container->get('tms_document_generator.manager.template')->update($template);
        }
        */
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}

