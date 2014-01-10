<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Generator;

interface DownloaderInterface
{
    /**
     * Send a document with a given name
     *
     * @param string filename
     */
    public function download($filename);
}