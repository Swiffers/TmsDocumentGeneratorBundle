<?php

/**
 * @license: MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Exception;

class UnexpectedTypeException extends \InvalidArgumentException
{
    public function __construct($value, $expectedType)
    {
        parent::__construct(sprintf(
            'UnexpectedTypeException - Expected argument of type "%s", "%s" given',
            $expectedType,
            is_object($value) ? get_class($value) : gettype($value)
        ));
    }
}