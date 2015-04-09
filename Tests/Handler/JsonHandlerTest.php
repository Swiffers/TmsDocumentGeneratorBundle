<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\Handler;

use Tms\Bundle\DocumentGeneratorBundle\Handler\JsonHandler;

/**
 * Class JsonHandlerTest
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\Tests\Handler
 */
class JsonHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * getMapData
     *
     * @return array
     */
    public function getMapData()
    {
        return array(
            array(
                '[]',
                true,
                array(),
            ),
            array(
                '{"offer_1":"msdata-123"}',
                true,
                array('offer_1'=>'msdata-123'),
            ),
            array(
                '{"address":{"street":"rue de lac","city":"paris"}}',
                true,
                array(
                    'address'=>array(
                        "street"=>"rue de lac",
                        "city"=>"paris",
                    ),
                ),
            ),
        );
    }

    /**
     * @param string $json
     * @param bool   $isJson
     * @param array  $result
     *
     * @dataProvider getMapData
     */
    public function testDecode($json, $isJson, $result)
    {
        $this->assertEquals($result, JsonHandler::decode($json, true));
    }

    /**
     * @param string $json
     * @param bool   $isJson
     * @param array  $result
     *
     * @dataProvider getMapData
     */
    public function testIsJson($json, $isJson, $result)
    {
        if ($isJson) {
            $this->assertEquals($result, JsonHandler::is_json($json, true, true));
        } else {
            $this->assertEquals($isJson, JsonHandler::is_json($json, true, true));
        }
    }

    /**
     * testArrayDecodeJsonRecursive
     */
    public function testArrayDecodeJsonRecursive()
    {
        $data = array(
            array('key1'=>'value1', 'key2'=>'value2'),
            array('key3'=>'{"key4":"value4","key5":"value5"}'),
            array(
                array(
                    'key6'=>array(
                        'key7'=>'{"key8":"value8"}',
                    ),
                ),
            ),
        );

        $result = array(
            array('key1'=>'value1', 'key2'=>'value2'),
            array('key3'=>array(
                'key4'=>'value4',
                'key5'=>'value5',
                ),
            ),
            array(
                array(
                    'key6'=>array(
                        'key7'=>array(
                            'key8'=>'value8',
                        ),
                    ),
                ),
            ),
        );

        $this->assertEquals($result, JsonHandler::array_decode_json_recursive($data, true));
    }

    /**
     * testJsonConversionException
     *
     * @expectedException \Tms\Bundle\DocumentGeneratorBundle\Exception\JsonConversionException
     */
    public function testDecodeJsonConversionException()
    {
        JsonHandler::decode('{:}');
    }

    /**
     * testJsonConversionException
     */
    public function testIsJsonOnNoString()
    {
        $this->assertEquals(false, JsonHandler::is_json(array(), true, true));
    }
}
