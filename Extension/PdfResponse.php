<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Extension;

use Symfony\Component\HttpFoundation\Response;

class PdfResponse extends Response
{
    /**
     * Create a proper PDF Response
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __construct($body)
    {
        parent::__construct();
        $this->headers->set('Content-Type', 'application/pdf');
        $this->setStatusCode(200);
        $this->setContent($body);
    }
}