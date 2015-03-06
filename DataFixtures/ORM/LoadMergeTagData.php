<?php

namespace Tms\Bundle\DocumentGeneratorBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadMergeTagData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
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
     * @var array list of identifier
     */
    private static $identifierEnum=['id', 'first_name', 'last_name', 'address', 'email', 'price', 'status', 'quality', 'phone_number', 'zip_code'];

    /**
     * @var array list of fetch alias
     */
    private static $fetchAliasEnum=['default', 'participation', 'user'];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        for ($j = 0; $j < 10; $j++) {
            for ($i = 1; $i <= 100; $i++) {
                $mergeTag = new MergeTag();
                $mergeTag
                    ->setIdentifier(
                        self::$identifierEnum[array_rand(self::$identifierEnum)]
                        )
                    ->setDescription('merge tag description'.$i)
                    ->setRequired($i%2)
                    ->setTemplateId(
                        $this->getReference("template".$i)
                        )
                    ->setFetcherAlias(
                        self::$fetchAliasEnum[array_rand(self::$fetchAliasEnum)]
                        )
                ;

                $this->container->get('tms_document_generator.manager.merge_tag')->add($mergeTag);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4;
    }
}

