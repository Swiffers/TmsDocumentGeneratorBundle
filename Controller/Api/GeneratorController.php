<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

class GeneratorController extends Controller
{
    public function generateAction(Request $request)
    {
        /*
        $template=new Template();
        $template->setName('template')
            ->setDescription('template description')
            ->setHtml('html')
            ->setCss('css')
        ;
        $em=$this->getDoctrine()->getManager();
        $em->persist($template);
        $em->flush();
        */
        $this->get('tms_document_generator.manager.template')->add(
            (new Template())->setName('template')
                ->setDescription('template description')
                ->setHtml('html')
                ->setCss('css')
        );
    }

    public function downloadAction(Request $request)
    {

    }

    public function previewAction(Request $request)
    {

    }
}
