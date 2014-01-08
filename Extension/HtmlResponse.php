<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Extension;

use Symfony\Component\HttpFoundation\Response;

class HtmlResponse extends Response
{
    /**
     * Create a proper HtmlResponse
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __construct($body)
    {
        parent::__construct();
        $this->headers->set('Content-Type', 'text/html');
        $this->setStatusCode(200);
        $this->setContent($body);
    }
}