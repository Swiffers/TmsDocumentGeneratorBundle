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
use Tms\Bundle\DocumentGeneratorBundle\Extension\HtmlResponse;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;
use Tms\Bundle\DocumentGeneratorBundle\Renderer\HtmlDocument;

/**
 * @Route("generate/")
 */
class GenerateController extends Controller
{
    /**
     * @Route("{id}.html")
     * @Method("GET")
     */
    public function htmlAction($id, Request $request)
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
        $htmlDocument = new HtmlDocument($template->getBody());

        return new HtmlResponse($htmlDocument->render($mergeTags));
    }
}