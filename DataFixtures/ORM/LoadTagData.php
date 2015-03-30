<?php

namespace Tms\Bundle\DocumentGeneratorBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadTagData
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\DataFixtures\ORM
 */
class LoadTagData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
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
     * @var array list of customers
     */
    private static $customerEnum=['sfr', 'orange', 'nivea', 'senseo', 'cocacola', 'hp', 'marie'];

    /**
     * @var array list of template type
     */
    private static $typeEnum=['email', 'bulletin'];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        for ($i = 1; $i <= 100; $i++) {
            $template = $this->getReference("template".$i);
            $template
                ->addTag(
                    (new Metadata())
                        ->setKey('customer')
                        ->setValue(self::$customerEnum[array_rand(self::$customerEnum)])
                        ->setNamespace('tags')
                )
                ->addTag(
                    (new Metadata())
                        ->setKey('type')
                        ->setValue(self::$typeEnum[array_rand(self::$typeEnum)])
                        ->setNamespace('tags')
                );

            $this->container->get('tms_document_generator.manager.template')->update($template);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}

