<?php

/**
 *
 * @author: Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 * @license: MIT
 *
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Exception;

class WrongParametersException extends \Exception
{
    public function __contruct()
    {
        return sprintf('Wrong parameters given');
    }
}
