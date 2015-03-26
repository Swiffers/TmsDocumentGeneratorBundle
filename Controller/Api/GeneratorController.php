<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tms\Bundle\DocumentGeneratorBundle\Handler\JsonHandler;

class GeneratorController extends Controller
{
    /**
     * HTTP Response with header filed Content-Type as The MIME type of the document generated.
     * Allow to show the document generated direct in the browser.
     *
     * @Route("/generate/{id}", name="tms_document_generator_generate")
     * @Method({"POST"})
     *
     * @param Request $request Data and options.
     * @param string  $id      The template document id.
     *
     * @return Response
     */
    public function generateAction(Request $request, $id)
    {
        $response = new Response();
        try {
            $parameters = $this->handleRequest($request, $id, false);
            $content = $this->get('tms_document_generator')->generate(
                $parameters['templateId'],
                $parameters['data'],
                $parameters['options'],
                $parameters['isPreview']
            );

            $response->headers->set(
                'Content-Type',
                $this->get('tms_document_generator.converter.registry')
                    ->getMimeType($parameters['options']['format'])
            );
            $response->setStatusCode(200);
            $response->setContent($content);
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            $response->setContent($e->getMessage());
        }

        return $response;
    }

    /**
     * HTTP Response with header filed: Content-Type as The MIME type of the document generated,
     * HTTP Response with header filed: Content-Disposition as Filename: template document id, Extension: corresponding to the MIME type.
     * Allow to raise a "File Download" dialogue box for the MIME type of the document generated in the browser.
     *
     * @Route("/download/{id}", name="tms_document_generator_download")
     * @Method({"POST"})
     *
     * @param Request $request Data and options.
     * @param string  $id      The template document id.
     *
     * @return Response
     */
    public function downloadAction(Request $request, $id)
    {
        $response = new Response();
        try {
            $parameters = $this->handleRequest($request, $id, false);
            $content = $this->get('tms_document_generator')->generate(
                $parameters['templateId'],
                $parameters['data'],
                $parameters['options'],
                $parameters['isPreview']
            );

            $response->headers->set(
                'Content-Type',
                $this->get('tms_document_generator.converter.registry')
                    ->getMimeType($parameters['options']['format'])
            );
            $response->headers->set('Content-Disposition', 'attachment; filename="'.$id.'.'.$parameters['options']['format'].'"');
            $response->setStatusCode(200);
            $response->setContent($content);
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            $response->setContent($e->getMessage());
        }

        return $response;
    }

    /**
     * HTTP Response with header filed: Content-Type as The MIME type of the document generated.
     * Allow to preview(without data) the document generated direct in the browser.
     *
     * @Route("/preview/{id}", name="tms_document_generator_preview")
     * @Method({"POST"})
     *
     * @param Request $request Data and options.
     * @param string  $id      The template document id.
     *
     * @return Response
     */
    public function previewAction(Request $request, $id)
    {
        $response = new Response();
        try {
            $parameters = $this->handleRequest($request, $id, true);
            $content = $this->get('tms_document_generator')->generate(
                $parameters['templateId'],
                $parameters['data'],
                $parameters['options'],
                $parameters['isPreview']
            );

            $response->headers->set(
                'Content-Type',
                $this
                    ->get('tms_document_generator.converter.registry')
                    ->getMimeType($parameters['options']['format'])
            );
            $response->setStatusCode(200);
            $response->setContent($content);
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            $response->setContent($e->getMessage());
        }

        return $response;
    }

    /**
     * Check and handle the request,
     * convert fields json: data and options to array of HTTP request.
     * Default data: array()
     * Default options: array('format' => 'html')
     *
     * @param Request $request   Data and options.
     * @param string  $id        The template document id.
     * @param bool    $isPreview If in the preview mode.
     *
     * @return array
     */
    private function handleRequest(Request $request, $id , $isPreview = false)
    {
        $parameters['templateId'] = $id;
        $parameters['data'] = $request->request->has('data')
            ? JsonHandler::decode($request->request->get('data'), true)
            : array()
        ;
        $parameters['options'] = $request->request->has('options')
            ? JsonHandler::decode($request->request->get('options'), true)
            : array('format' => 'html')
        ;
        $parameters['isPreview'] = $isPreview;

        return $parameters;
    }
}
