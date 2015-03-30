<?php

/**
 * @license: MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Exception;

/**
 * Class JsonConversionException
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\Exception
 */
class JsonConversionException extends \InvalidArgumentException
{
    /**
     * constructor
     *
     * @param string $method
     * @param string $errorMessage
     */
    public function __construct($method, $errorMessage)
    {
        parent::__construct(sprintf(
            'JsonConversionException - %s: %s',
            $method,
            $errorMessage
        ));
    }
}