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
     * @Route("{id}.{format}", requirements={"format"="html|pdf"})
     * @Method("GET")
     */
    public function generateAction($id, $format, Request $request)
    {
        $template = $this->get('tms_documentgenerator.manager.template')->find($id);
        if (!$template) {
            return new Response('Document not found', 404);
        }

        $security = $this->get('tms_document_generator.security');
        $parameters = $security->decodeQueryData($request->query->get('data', null));
        $token = $request->query->get('token', null);

        if (false === $security->isValidToken($parameters, $token)) {
            return new Response('Unvalid token', 400);
        }

        $mergeTags = array();
        foreach ($parameters as $key => $value) {
            $mergeTags[sprintf('{%s}', $key)] = $value;
        }

        $documentClass = sprintf('Tms\Bundle\DocumentGeneratorBundle\Document\%sDocument', ucwords($format));
        $responseClass = sprintf('Tms\Bundle\DocumentGeneratorBundle\Extension\%sResponse', ucwords($format));
        if (!class_exists($documentClass) || !class_exists($responseClass)) {
            return new Response('Unknown format', 400);
        }

        $config = $this->container->getParameter('tms_document_generator');
        $document = new $documentClass($template->getHtml(), $template->getCss(), $this->get($config[strtolower($format)]));

        return new $responseClass($document->render($mergeTags));
    }
}