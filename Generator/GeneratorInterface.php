<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Generator;

interface GeneratorInterface
{
    /**
     * Generate a document from a request.
     *
     * @param string  $templateId The template document id.
     * @param array   $data       The data(with parameters used by fetcher to fetch data for each merge tag of the template).
     * @param array   $options    The generation options(with format).
     * @param boolean $isPreview  If in the mode preview.
     *
     * @return string
     *
     * @throws \UnexpectedValueException When the template or format cannot be found
     */
    public function generate($templateId, array $data = array(), array $options = array(), $isPreview = false);
}