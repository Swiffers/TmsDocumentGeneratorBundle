<?php

namespace Tms\Bundle\DocumentGeneratorBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

class LoadTemplateData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        for ($i = 1; $i <= 100; $i++) {
            $template = new Template();
            $template->setName('template'.$i)
                ->setDescription('template description'.$i)
                ->setHtml('html'.$i)
                ->setCss('css'.$i)
            ;

            $em->persist($template);
            $em->flush();
            $this->addReference("template".$i, $template);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}

