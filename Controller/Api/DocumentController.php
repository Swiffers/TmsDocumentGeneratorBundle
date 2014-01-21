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
        $template = $this->get('tms_document_generator.manager.template')->find($id);
        if (!$template) {
            return new Response('Document not found', 404);
        }

        $data = $request->query->get('data', null);
        $token = $request->query->get('token', null);
        if (null === $data || null === $token) {
            return new Response('Unvalid parameters', 400);
        }

        $security = $this->get('tms_document_generator_security.security');
        $parameters = $security->decodeQueryDataToParameters($data);
        if (null === $parameters) {
            return new Response('Bad parameters', 400);
        }

        if (false === $security->checkTokenValidity($parameters, $template->getSalt(), $token)) {
            return new Response('Unvalid token', 403);
        }

        $documentClass = sprintf('Tms\Bundle\DocumentGeneratorBundle\Document\%sDocument', ucwords($format));
        $responseClass = sprintf('Tms\Bundle\DocumentGeneratorBundle\Extension\%sResponse', ucwords($format));
        if (!class_exists($documentClass) || !class_exists($responseClass)) {
            return new Response('Unknown format', 400);
        }

        $generatorServices = $this->container->getParameter('tms_document_generator');
        $document = new $documentClass($template, $this->get($generatorServices[strtolower($format)]));
        $content = $document->display($parameters);

        return new $responseClass($content);
    }

    /**
     * @Route("download/{id}.{format}", requirements={"format"="pdf"})
     */
    public function downloadAction($id, $format, Request $request)
    {
        $template = $this->get('tms_document_generator.manager.template')->find($id);
        if (!$template) {
            return new Response('Document not found', 404);
        }

        $data = $request->query->get('data', null);
        $token = $request->query->get('token', null);
        if (null === $data || null === $token) {
            return new Response('Unvalid parameters', 400);
        }
        $name = $request->query->get('name', null);

        $security = $this->get('tms_document_generator_security.security');
        $parameters = $security->decodeQueryDataToParameters($data);
        if (null === $parameters) {
            return new Response('Bad parameters', 400);
        }

        if (false === $security->checkTokenValidity($parameters, $template->getSalt(), $token)) {
            return new Response('Unvalid token', 403);
        }

        $documentClass = sprintf('Tms\Bundle\DocumentGeneratorBundle\Document\%sDocument', ucwords($format));
        $responseClass = sprintf('Tms\Bundle\DocumentGeneratorBundle\Extension\%sResponse', ucwords($format));
        if (!class_exists($documentClass) || !class_exists($responseClass)) {
            return new Response('Unknown format', 400);
        }

        $generatorServices = $this->container->getParameter('tms_document_generator');
        $document = new $documentClass($template, $this->get($generatorServices[strtolower($format)]));
        $content = $document->display($parameters);

        $response = new $responseClass($content);
        $filename = (null !== $name ? $name : $id) . '.' . $format;
        $response->headers->set("Content-Disposition", "attachment; filename=\"$filename\"");

        return $response;
    }

    /**
     * @Route("template/{id}/salt", requirements={"id"="\d+"})
     */
    public function templateSaltAction($id, Request $request)
    {
        $sentSecurityToken = $request->query->get('token', null);
        if (null === $sentSecurityToken) {
            return new Response('Token not given', 400);
        }

        $security = $this->get('tms_document_generator_security.security');
        if ($sentSecurityToken !== $security->getSecurityToken()) {
            return new Response('Unvalid token', 403);
        }

        $template = $this->get('tms_documentgenerator.manager.template')->find($id);
        if (!$template) {
            return new Response('Document not found', 404);
        }

        return new Response($template->getSalt());
    }

    public function tokenAction($id, Request $request)
    {
        $template = $this->get('tms_documentgenerator.manager.template')->find($id);
        if (!$template) {
            return new Response('Document not found', 404);
        }
        $data = $request->query->get('data', null);
        $security = $this->get('tms_document_generator_security.security');
        $parameters = $security->decodeQueryDataToParameters($data);
        $token = $security->generateToken(implode('.', $parameters), $template->getSalt());
        var_dump($parameters);
        return new Response('Token: ' . $token);
    }
}