<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as SfTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

/**
 * @Route("templates/")
 */
class TemplateController extends Controller
{
    /**
     * @Route("")
     * @Method("GET")
     * @SfTemplate()
     */
    public function listAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $templateRepository = $entityManager->getRepository('TmsDocumentGeneratorBundle:Template');

        return array(
            'templates' => $templateRepository->findAll()
        );
    }

    /**
     * @Route("create")
     * @SfTemplate()
     */
    public function createAction(Request $request)
    {
        $template = new Template();
        $form = $this->createForm('template', $template);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $template = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($template);
                $entityManager->flush();

                return $this->redirect($this->generateUrl('tms_documentgenerator_template_list'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("edit/{id}")
     * @SfTemplate()
     */
    public function editAction($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $templateRepository = $entityManager->getRepository('TmsDocumentGeneratorBundle:Template');
        $template = $templateRepository->find($id);
        if (!$template) {
            return $this->redirect($this->generateUrl('tms_documentgenerator_template_list'));
        }

        $form = $this->createForm('template', $template);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $template = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($template);
                $entityManager->flush();

                return $this->redirect($this->generateUrl('tms_documentgenerator_template_list'));
            }
        }

        return array(
            'template' => $template,
            'form' => $form->createView()
        );
    }
}