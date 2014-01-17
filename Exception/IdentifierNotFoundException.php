<?php

/**
 *
 * @author: Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 * @license: MIT
 *
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Exception;

class IdentifierNotFoundException extends \Exception
{
    public function __contruct($identifier)
    {
        return sprintf('The %s identifier is not defined in the document', $identifier);
    }
}
