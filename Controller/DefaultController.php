<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TmsDocumentGeneratorBundle:Default:index.html.twig', array('name' => $name));
    }
}
