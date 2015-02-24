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
     * @param integer $template_id
     * @param array $data
     * @param array $options
     *
     * @return string
     */
    public function generate(integer $template_id, array $data, array $options);
}