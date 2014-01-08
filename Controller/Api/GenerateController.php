<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("generate/")
 */
class GenerateController extends Controller
{
    /**
     * @Route("{id}.{format}")
     * @Method("GET")
     */
    public function generateAction($id, $format, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $templateRepository = $entityManager->getRepository('TmsDocumentGeneratorBundle:Template');

        $template = $templateRepository->find($id);
        if (!$template) {
            return new Response('Template not found', 404);
        }

        $parameters = $request->query->all();
        $mergeTags = array();
        foreach ($parameters as $key => $value) {
            $mergeTags[sprintf('{%s}', $key)] = $value;
        }

        $documentClass = sprintf('Tms\Bundle\DocumentGeneratorBundle\Renderer\%sDocument', ucwords($format));
        $responseClass = sprintf('Tms\Bundle\DocumentGeneratorBundle\Extension\%sResponse', ucwords($format));
        if (!class_exists($documentClass) || !class_exists($responseClass)) {
            return new Response('Output format does not exist', 400);
        }
        $document = new $documentClass($template->getBody());

        return new $responseClass($document->render($mergeTags));
    }
}