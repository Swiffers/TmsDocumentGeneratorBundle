<?php

/**
 * @author Baptiste Bouchereau <baptiste.bouchereau@idci-consulting.fr>
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Generator;

use Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator;

class Wkhtml2PdfGenerator implements GeneratorInterface
{
    private $wkhtml2pdf;

    /**
     * Constructor
     *
     * @param LoggableGenerator $wkhtml2pdf
     */
    public function __construct(LoggableGenerator $wkhtml2pdf)
    {
        $this->wkhtml2pdf = $wkhtml2pdf;
    }

    /**
     * {@inheritDoc}
     */
    public function generate($html)
    {
        return $this->wkhtml2pdf->getOutputFromHtml($html);
    }

    /**
     * {@inheritDoc}
     */
    public function getMimeType()
    {
        return 'application/pdf';
    }
}