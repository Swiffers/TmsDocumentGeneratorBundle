<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Handler;

class JsonHandler
{

    /**
     * Json error codes may be returned by json_last_error() and messages corresponding
     *
     * @var array
     */
    protected static $_messages = array(
        JSON_ERROR_NONE => 'No error has occurred',
        JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
        JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
        JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
        JSON_ERROR_SYNTAX => 'Syntax error',
        JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded',
        JSON_ERROR_RECURSION => 'One or more recursive references in the value to be encoded',
        JSON_ERROR_INF_OR_NAN => 'One or more NAN or INF values in the value to be encoded',
        JSON_ERROR_UNSUPPORTED_TYPE => 'A value of a type that cannot be encoded was given'
    );

    /**
     * @param mixed $value
     * @param int   $options
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function encode($value, $options = 0)
    {
        $result = json_encode($value, $options);

        if($result) {
            return $result;
        }

        $errorMessage = isset(static::$_messages[json_last_error()])
            ? static::$_messages[json_last_error()]
            : 'Unknown error'
        ;

        throw new \Exception("Json encode: ".$errorMessage);
    }

    /**
     * @param string $json
     * @param bool   $assoc
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public static function decode($json, $assoc = false)
    {
        $result = json_decode($json, $assoc);

        if($result) {
            return $result;
        }

        $errorMessage = isset(static::$_messages[json_last_error()])
            ? static::$_messages[json_last_error()]
            : 'Unknown error'
        ;

        throw new \Exception("Json decode: ".$errorMessage);
    }
}