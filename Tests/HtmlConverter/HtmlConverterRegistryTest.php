<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\HtmlConverter;

use Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterRegistry;

/**
 * Class HtmlConverterRegistryTest
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\Tests\HtmlConverter
 */
class HtmlConverterRegistryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * testSetHtmlConverter
     *
     * @return HtmlConverterRegistry
     */
    public function testSetHtmlConverter()
    {
        $nullHtmlConverter =
            $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\NullHtmlConverter')
                ->disableOriginalConstructor()
                ->getMock();

        $nullHtmlConverter
            ->expects($this->once())
            ->method('getMimeType')
            ->will($this->returnValue('text/html'));

        $pdfHtmlConverter =
            $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\PdfHtmlConverter')
                ->disableOriginalConstructor()
                ->getMock();

        $pdfHtmlConverter
            ->expects($this->once())
            ->method('getMimeType')
            ->will($this->returnValue('application/pdf'));

        $registry = new HtmlConverterRegistry();

        $this->assertInstanceOf(
            'Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterRegistry',
            $registry->setHtmlConverter('html', $nullHtmlConverter)
        );

        $this->assertInstanceOf(
            'Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterRegistry',
            $registry->setHtmlConverter('pdf', $pdfHtmlConverter)
        );

        return $registry;
    }

    /**
     * testHasHtmlConverter
     *
     * @param HtmlConverterRegistry $registry
     *
     * @depends testSetHtmlConverter
     */
    public function testHasHtmlConverter(HtmlConverterRegistry $registry)
    {
        $this->assertTrue($registry->hasHtmlConverter('html'));
        $this->assertTrue($registry->hasHtmlConverter('pdf'));
        $this->assertFalse($registry->hasHtmlConverter('docx'));
    }

    /**
     * testGetHtmlConverter
     *
     * @param HtmlConverterRegistry $registry
     *
     * @depends testSetHtmlConverter
     */
    public function testGetHtmlConverter(HtmlConverterRegistry $registry)
    {
        $this->assertInstanceOf(
            'Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterInterface',
            $registry->getHtmlConverter('html')
        );

        $this->assertInstanceOf(
            'Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterInterface',
            $registry->getHtmlConverter('pdf')
        );
    }

    /**
     * testGetMimeType
     *
     * @param HtmlConverterRegistry $registry
     *
     * @depends testSetHtmlConverter
     */
    public function testGetMimeType(HtmlConverterRegistry $registry)
    {
        $this->assertEquals('text/html', $registry->getMimeType('html'));
        $this->assertEquals('application/pdf', $registry->getMimeType('pdf'));
    }

    /**
     * @param HtmlConverterRegistry $registry
     *
     * @expectedException \Tms\Bundle\DocumentGeneratorBundle\Exception\UnexpectedTypeException
     *
     * @depends testSetHtmlConverter
     */
    public function testUnexpectedTypeException(HtmlConverterRegistry $registry)
    {
        $registry->getHtmlConverter(array());
    }

    /**
     * @param HtmlConverterRegistry $registry
     *
     * @expectedException \InvalidArgumentException
     *
     * @depends testSetHtmlConverter
     */
    public function testInvalidArgumentException(HtmlConverterRegistry $registry)
    {
        $registry->getHtmlConverter('docx');
    }
}
