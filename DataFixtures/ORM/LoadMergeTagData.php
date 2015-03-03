<?php

namespace Tms\Bundle\DocumentGeneratorBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag;

class LoadMergeTagData extends AbstractFixture implements OrderedFixtureInterface
{
    private static $identifierEnum=['id', 'first_name', 'last_name', 'address', 'email', 'price', 'status', 'quality', 'phone_number', 'zip_code'];
    private static $fetchAliasEnum=['default', 'participation', 'user'];

    public function load(ObjectManager $em)
    {
        for ($j = 0; $j < 3; $j++) {
            for ($i = 1; $i <= 100; $i++) {
                $mergetag = new MergeTag();
                $mergetag->setIdentifier(self::$identifierEnum[array_rand(self::$identifierEnum)])
                    ->setDescription('mergetag description'.$i)
                    ->setRequired($i%2)
                    ->setTemplateId($em->merge($this->getReference("template".$i)))
                    ->setFetcherAlias(self::$fetchAliasEnum[array_rand(self::$fetchAliasEnum)])
                ;
                $em->persist($mergetag);
                $em->flush();
            }
        }
    }

    public function getOrder()
    {
        return 2;
    }
}

