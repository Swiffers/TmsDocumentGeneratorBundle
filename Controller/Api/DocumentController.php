<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;
use Tms\Bundle\DocumentGeneratorBundle\Entity\ConfigurationTag;

/**
 * @Method("GET")
 */
class DocumentController extends Controller
{
    /**
     * GetEndpoint
     *
     * @Route("/endpoint.{_format}", name="tms_document_generator_api_endpoint", defaults={"_format"="json"})
     * @Method({"GET"})
     */
    public function getEndpointAction(Request $request, $_format)
    {
        $configuration = $this->container->getParameter('tms_document_generator.configuration');
        $data = array(
            'publicEndpoint' => $configuration['api_public_endpoint']
        );

        $response = new Response();
        $response->setPublic();
        $response->setStatusCode(200);
        // Cache for one year
        $response->setMaxAge(31536000);
        $response->setSharedMaxAge(31536000);

        if ($_format == 'json') {
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($data));
        } elseif ($_format == 'xml') {
            $xml = new \SimpleXMLElement('<root/>');
            $data = array_flip($data);
            array_walk_recursive($data, array($xml, 'addChild'));
            $response->headers->set('Content-Type', 'text/xml');
            $response->setContent($xml->asXML());
        }

        return $response;
    }

    /**
     * @Route("/generate/{id}.{format}", name="tms_document_generator_api_generate")
     * @Method({"GET"})
     */
    public function generateAction($id, $format, Request $request)
    {
        try {
            $template = $this->get('tms_document_generator.manager.template')->find($id);
            $parameters = $this->checkRequestAndGetParameters($format, $template, $request);
        } catch (\Exception $exception) {
            return new Response($exception->getMessage(), $exception->getCode());
        }
        $document = $this->get(sprintf(
            'tms_document_generator.document.%s',
            $format
        ));

        $content = $document->display($template, $parameters, $request);

        $response = new Response();
        $response->headers->set('Content-Type', $document->getMimeType());
        $response->setStatusCode(200);
        $response->setContent($content);

        return $response;
    }

    /**
     * @Route("/download/{id}.{format}", name="tms_document_generator_api_download")
     * @Method({"GET"})
     */
    public function downloadAction($id, $format, Request $request)
    {
        $template = $this->get('tms_document_generator.manager.template')->find($id);
        try {
            $parameters = $this->checkRequestAndGetParameters($format, $template, $request);
        } catch (\Exception $exception) {
            return new Response($exception->getMessage(), $exception->getCode());
        }
        $document = $this->get(sprintf(
            'tms_document_generator.document.%s',
            $format
        ));
        $content = $document->display($template, $parameters, $request);
        $name = $request->query->get('name', null);
        $filename = sprintf('%s.%s', ($name ? $name : $id), $format);

        $response = new Response();
        $response->headers->set('Content-Type', $document->getMimeType());
        $response->headers->set("Content-Disposition", "attachment; filename=\"$filename\"");
        $response->setContent($content);

        return $response;
    }

    /**
     * @Route("/template/{id}/salt", name="tms_document_generator_api_template_salt", requirements={"id"="\d+"})
     * @Method({"GET"})
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

        return new Response('Token: ' . $token);
    }

    /**
     * Checks if the request is valid and returns the parameters
     *
     * @param string   $format
     * @param Template $template
     * @param Request  $request
     * @throws \Exception
     * @return array
     */
    private function checkRequestAndGetParameters($format, Template $template, Request $request)
    {
        $configuration = $this->container->getParameter('tms_document_generator.configuration');

        if (!in_array($format, array_keys($configuration['formats']))) {
            throw new \Exception('Format not available', 400);
        }

        if (!$template) {
            throw new \Exception('Document Not Found', 404);
        }

        $data = $request->query->get('data', null);
        $token = $request->query->get('token', null);
        if (null === $data || null === $token) {
            throw new \Exception('Unvalid parameters', 400);
        }

        $security = $this->get('tms_document_generator_security.security');
        $parameters = $security->decodeQueryDataToParameters($data);
        if (null === $parameters) {
            throw new \Exception('Bad parameters', 400);
        }

        if (!$security->checkTokenValidity($parameters, $template->getSalt(), $token)) {
            throw new \Exception('Unvalid token', 403);
        }

        return $parameters;
    }
}
