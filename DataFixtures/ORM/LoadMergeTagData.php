<?php

namespace Tms\Bundle\DocumentGeneratorBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadMergeTagData
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\DataFixtures\ORM
 */
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
     * @var array list of fetch alias
     */
    private static $fetchAliasEnum=['default', 'participation', 'user'];

    /**
     * @var array
     */
    private static $DefaultIdentifierEnum = ['first_name', 'last_name', 'address', 'email', 'price', 'status', 'quality', 'phone_number', 'zip_code'];

    /**
     * @var array
     */
    private static $UserIdentifierEnum = ['user_id1', 'user_id2',  'user_id3',  'user_id4',  'user_id5'];

    /**
     * @var array
     */
    private static $ParticipationIdentifierEnum = ['participation_id1', 'participation_id2', 'participation_id3', 'participation_id4', 'participation_id5'];

    /**
     * @var array list of default Value
     */
    private static $defaultValueEnum=[null, 'defaultValue1', 'defaultValue2', 'defaultValue3', 'defaultValue4', 'defaultValue5'];

    /**
     * @param $fetchAlias
     */
    private function getIdentifier($fetchAlias)
    {
        switch ($fetchAlias) {
            case 'default':
                return self::$DefaultIdentifierEnum[array_rand(self::$DefaultIdentifierEnum)];
            case 'user':
                return self::$UserIdentifierEnum[array_rand(self::$UserIdentifierEnum)];
            case 'participation':
                return self::$ParticipationIdentifierEnum[array_rand(self::$ParticipationIdentifierEnum)];
        }
    }

    /**
     * @param $fetchAlias
     *
     * @return string|null
     */
    private function getdefaultValue($fetchAlias)
    {
        switch ($fetchAlias) {
            case 'default':
                return self::$defaultValueEnum[array_rand(self::$defaultValueEnum)];
            case 'user':
            case 'participation':
                return null;
        }
    }

    /**
     * @param $fetchAlias
     *
     * @return string|null
     */
    private function getFetchDataKey($fetchAlias, $identifier)
    {
        switch ($fetchAlias) {
            case 'default':
                return array($identifier);
            case 'user':
            case 'participation':
                return array('id', 'status');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        for ($j = 0; $j < 5; $j++) {
            for ($i = 1; $i <= 100; $i++) {
                $mergeTag = new MergeTag();
                $mergeTag
                    ->setFetcherAlias(
                        self::$fetchAliasEnum[array_rand(self::$fetchAliasEnum)]
                    )
                    ->setIdentifier(
                        $this ->getIdentifier($mergeTag->getFetcherAlias())
                    )
                    ->setDescription('merge tag description'.$i)
                    ->setRequired(($j+1)%2)
                    ->setTemplateId(
                        $this->getReference("template".$i)
                    )
                    ->setDefaultValue(
                        $this->getdefaultValue($mergeTag->getFetcherAlias())
                    )
                    ->setFetchDataKeys(
                        $this->getFetchDataKey($mergeTag->getFetcherAlias(), $mergeTag->getIdentifier())
                    );

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

