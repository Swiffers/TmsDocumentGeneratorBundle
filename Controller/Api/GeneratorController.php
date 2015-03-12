<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

class GeneratorController extends Controller
{
    /**
     * @Route("/test", name="tms_document_generator_test")
     * @Method({"GET"})
     */
    public function testAction()
    {
        return new Response(
            json_encode(
                $this
                    ->get('tms_document_generator.fetcher.registry')
                    ->getDataFetcher('participation')
                    ->fetch(
                        array("participation_id"=>"52976d6fe63ea02c768b4567")
                    )
            )
        );
    }

    /**
     * @Route("/generate/{id}", name="tms_document_generator_generate")
     * @Method({"POST"})
     *
     * @param Request $request Data and options
     * @param string  $id      The template document id.
     */
    public function generateAction(Request $request, $id)
    {
        $data = json_decode($request->request->get('data'), true);
        $options = json_decode($request->request->get('options'), true);
        $options['mode'] = 'generate';
        $result = $this->get('tms_document_generator')->generate($id, $data, $options);

        var_dump($result);die;
    }

    /**
     * @Route("/download/{id}", name="tms_document_generator_download")
     * @Method({"POST"})
     *
     * @param Request $request Data and options
     * @param string  $id      The template document id.
     */
    public function downloadAction(Request $request, $id)
    {

    }

    /**
     * @Route("/preview/{id}", name="tms_document_generator_preview")
     * @Method({"POST"})
     *
     * @param Request $request Data and options
     * @param string  $id      The template document id.
     *
     * @return Response
     */
    public function previewAction(Request $request, $id)
    {
        $data = array();
        $options = json_decode($request->request->get('options'), true);
        $options['mode'] = 'preview';
        $content = $this->get('tms_document_generator')->generate($id, $data, $options);

        $response = new Response();
        //$response->headers->set('Content-Type', MimeType);
        $response->setStatusCode(200);
        $response->setContent($content);

        return $response;
    }
}
