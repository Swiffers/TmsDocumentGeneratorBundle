<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GeneratorController extends Controller
{
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

}
