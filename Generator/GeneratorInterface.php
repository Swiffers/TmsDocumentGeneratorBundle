<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Generator;

interface GeneratorInterface
{
    /**
     * Generate a document from a request
     *
     * @param string  $templateId  The template document id.
     * @param array   $data        The bases data to merge.
     * @param array   $options     The generation options.
     * @param boolean $isPreview   If the generation must not fetch the given data.
     *
     * @return string
     */
    public function generate($templateId, array $data = array(), array $options = array(), $isPreview = false);
}