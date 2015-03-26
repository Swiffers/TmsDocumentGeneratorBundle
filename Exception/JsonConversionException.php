<?php

/**
 * @license: MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Exception;

class JsonConversionException extends \InvalidArgumentException
{
    public function __construct($method, $errorMessage)
    {
        parent::__construct(sprintf(
            'JsonConversionException - %s: %s',
            $method,
            $errorMessage
        ));
    }
}