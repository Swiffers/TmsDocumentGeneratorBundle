<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Security;

class Security
{
    private static $algorithm = 'md5'; // Algorithm used to generate the token

    /**
     * Generate a token from a given string
     *
     * @param string $data
     * @param string $key
     * @return string
     */
    public function generateToken($data, $key)
    {
        return hash_hmac(self::$algorithm, $data, $key);
    }

    /**
     * Decode data and return an associative array
     *
     * @param string $queryData
     * @return array
     */
    public function decodeQueryData($queryData)
    {
        return json_decode(base64_decode($queryData), true);
    }

    /**
     * Determine if a token is valid
     *
     * @param array $data
     * @param string $key
     * @param string $token
     * @return boolean
     */
    public function isValidToken($data, $key, $token)
    {
        if (empty($data['lastname']) || empty($data['firstname'])) {
            return false;
        }

        $recalculatedToken = $this->generateToken($data['lastname'] . $data['firstname'], $key);
        if ($recalculatedToken !== $token) {
            return false;
        }

        return true;
    }
}