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
 * @Method("GET")
 */
class DocumentController extends Controller
{
    /**
     * @Route("generate/{id}.{format}", requirements={"format"="html|pdf"})
     */
    public function generateAction($id, $format, Request $request)
    {
        $template = $this->get('tms_documentgenerator.manager.template')->find($id);
        if (!$template) {
            return new Response('Document not found', 404);
        }

        $data = $request->query->get('data', null);
        $token = $request->query->get('token', null);
        if (null === $data || null === $token) {
            return new Response('Unvalid parameters', 400);
        }

        $security = $this->get('tms_document_generator.security');
        $parameters = $security->decodeQueryData($data);
        if (null === $parameters) {
            return new Response('Bad parameters', 400);
        }

        if (false === $security->isValidToken($parameters, $template->getSalt(), $token)) {
            return new Response('Unvalid token', 403);
        }

        $documentClass = sprintf('Tms\Bundle\DocumentGeneratorBundle\Document\%sDocument', ucwords($format));
        $responseClass = sprintf('Tms\Bundle\DocumentGeneratorBundle\Extension\%sResponse', ucwords($format));
        if (!class_exists($documentClass) || !class_exists($responseClass)) {
            return new Response('Unknown format', 400);
        }

        $generatorServices = $this->container->getParameter('tms_document_generator');
        //die(var_dump($this->get($generatorServices[strtolower($format)])));
        $document = new $documentClass($template->getHtml(), $template->getCss(), $template->getMergeTags(), $this->get($generatorServices[strtolower($format)]));

        return new $responseClass($document->render($parameters));
    }

    /**
     * @Route("download/{id}/{name}.{format}", requirements={"format"="pdf", "name"="\w+"})
     */
    public function downloadAction($id, $name, $format, Request $request)
    {
        $template = $this->get('tms_documentgenerator.manager.template')->find($id);
        if (!$template) {
            return new Response('Document not found', 404);
        }

        $data = $request->query->get('data', null);
        $token = $request->query->get('token', null);
        if (null === $data || null === $token) {
            return new Response('Unvalid parameters', 400);
        }

        $security = $this->get('tms_document_generator.security');
        $parameters = $security->decodeQueryData($data);
        if (null === $parameters) {
            return new Response('Bad parameters', 400);
        }

        if (false === $security->isValidToken($parameters, $template->getSalt(), $token)) {
            return new Response('Unvalid token', 403);
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

        return new $responseClass($document->download($mergeTags, $name));
    }
}