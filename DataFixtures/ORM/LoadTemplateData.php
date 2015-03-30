<?php

namespace Tms\Bundle\DocumentGeneratorBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadTemplateData
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\DataFixtures\ORM
 */
class LoadTemplateData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
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
        for ($i = 1; $i <= 100; $i++) {
            $template = new Template();
            $template->setName('template'.$i)
                ->setDescription('template description'.$i)
                ->setHtml('html'.$i)
                ->setCss('css'.$i);

            $this->container->get('tms_document_generator.manager.template')->add($template);
            $this->addReference("template".$i, $template);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}

