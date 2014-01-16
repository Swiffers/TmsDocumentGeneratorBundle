<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Security;

class Security
{
    private static $algorithm = 'md5';
    private static $key = '';

    /**
     * Generate a token from a given string
     *
     * @param string $data
     * @return string
     */
    public function generateToken($data)
    {
        return hash_hmac(self::$algorithm, $data, self::$key);
    }

    /**
     *
     * @param string $queryData
     * @return array
     */
    public function decodeQueryData($queryData)
    {
        $decodedData = base64_decode($queryData);
        $parameters = explode('&', $decodedData);

        $data = array();
        foreach ($parameters as $parameter) {
            $preparedParameter = explode('=', $parameter);
            $data[$preparedParameter[0]] = $preparedParameter[1];
        }

        return $data;
    }

    /**
     * Determine if the token is valid
     *
     * @param array $data
     * @param string $token
     * @return boolean
     */
    public function isValidToken(array $data, $token)
    {
        if (empty($data['lastname']) || empty($data['firstname'])) {
            return false;
        }

        $recalculatedToken = $this->generateToken($data['lastname'] . $data['firstname']);
        if ($recalculatedToken !== $token) {
            return false;
        }

        return true;
    }
}