<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Tms\Bundle\DocumentGeneratorBundle\Entity\Document;
use Tms\Bundle\DocumentGeneratorBundle\Form\Type\DocumentType;

/**
 * @Route("documents/")
 */
class DocumentController extends Controller
{
    /**
     * @Route("")
     * @Method("GET")
     * @Template()
     */
    public function listAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $documentRepository = $entityManager->getRepository('TmsDocumentGeneratorBundle:Document');

        return array(
            'documents' => $documentRepository->findAll()
        );
    }

    /**
     * @Route("create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $document = new Document();
        $form = $this->createForm('document', $document);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $document = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($document);
                $entityManager->flush();

                return $this->redirect($this->generateUrl('tms_documentgenerator_document_list'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }
}