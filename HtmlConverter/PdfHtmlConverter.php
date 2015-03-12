<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\HtmlConverter;

use Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator;

class PdfHtmlConverter implements HtmlConverterInterface
{
    /**
     * @var LoggableGenerator
     */
    protected $wkhtmltopdf;

    /**
     * Constructor
     *
     * @param LoggableGenerator $wkhtmltopdf
     */
    public function __construct(LoggableGenerator $wkhtmltopdf)
    {
        $this->wkhtmltopdf = $wkhtmltopdf;
    }

    /**
     * {@inheritDoc}
     */
    public function convert($html)
    {
        return $this->wkhtmltopdf->getOutputFromHtml($html);
    }
}