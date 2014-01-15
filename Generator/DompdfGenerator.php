<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Generator;

class DompdfGenerator implements GeneratorInterface, RendererInterface, DownloaderInterface
{
    private $dompdf;

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        return $this->dompdf->output();
    }

    /**
     * {@inheritDoc}
     */
    public function generateFromHtml($html)
    {
        $this->dompdf = new \DOMPDF();
        $this->dompdf->set_paper("a4", "pt");
        $this->dompdf->load_html($html);
        $this->dompdf->render();
    }

    /**
     * {@inheritDoc}
     */
    public function download($filename)
    {
        $this->dompdf->stream("$filename.pdf", array("Attachment" => true));
    }
}