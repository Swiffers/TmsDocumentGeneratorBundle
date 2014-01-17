<?php

/**
 *
 * @author: Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 * @license: MIT
 *
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Exception;

class IdentifierRequiredException extends \Exception
{
    public function __contruct($identifierName)
    {
        return sprintf('%s is required in the document', $identifierName);
    }
}
