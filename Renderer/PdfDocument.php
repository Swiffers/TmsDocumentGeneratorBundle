<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Renderer;

class PdfDocument extends AbstractDomDocument
{
    private $dompdf;

    public function __construct($source)
    {
        parent::__construct($source);
        $this->dompdf = new \DOMPDF();
    }

    /**
     * Render a source with the tags
     *
     * @param array $parameters
     * @return text
     */
    public function render(array $parameters)
    {
        $html = $this->renderDom($parameters);
        $this->dompdf->set_paper("a4", "pt");
        $this->dompdf->load_html($html);
        $this->dompdf->render();

        return $this->dompdf->output();
    }
}
