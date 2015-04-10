<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\HtmlConverter;

use Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\NullHtmlConverter;

/**
 * Class NullHtmlConverterTest
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\Tests\HtmlConverter
 */
class NullHtmlConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * testConvert
     *
     * @return NullHtmlConverter
     */
    public function testConvert()
    {
        $nullHtmlConverter = new NullHtmlConverter();

        $html = '<html></html>';
        $this->assertEquals($html, $nullHtmlConverter->convert($html));

        return $nullHtmlConverter;
    }

    /**
     * testGetMimeType
     *
     * @param NullHtmlConverter $nullHtmlConverter
     *
     * @depends testConvert
     */
    public function testGetMimeType(NullHtmlConverter $nullHtmlConverter)
    {
        $this->assertEquals('text/html', $nullHtmlConverter->getMimeType());
    }
}
