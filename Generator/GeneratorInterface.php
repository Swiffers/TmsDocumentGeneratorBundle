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
     * @param string  $template_id The template document id.
     * @param array   $data        The bases data to merge.
     * @param array   $options     The generation options.
     *
     * @return string
     */
    public function generate($template_id, array $data = array(), array $options = array());
}