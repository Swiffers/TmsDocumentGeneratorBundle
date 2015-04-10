<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Tests\Generator;

use Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;
use Tms\Bundle\DocumentGeneratorBundle\Exception\MissingGenerationParametersException;
use Tms\Bundle\DocumentGeneratorBundle\Manager\TemplateManager;
use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistryInterface;
use Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterRegistryInterface;
use \Twig_Environment;
use \Twig_Error;
use \Twig_Error_Runtime;

use Tms\Bundle\DocumentGeneratorBundle\Generator\Generator;

/**
 * Class GeneratorTest
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\Tests\Generator
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Template
     */
    protected $template;

    /**
     * @var TemplateManager
     */
    protected $templateManager;

    /**
     * @var DataFetcherRegistryInterface
     */
    protected $dataFetcherRegistry;

    /**
     * @var HtmlConverterRegistryInterface
     */
    protected $htmlConverterRegistry;

    /**
     * @var $twig
     */
    protected $twig;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->templateManager =
            $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\Manager\TemplateManager')
                ->disableOriginalConstructor()
                ->setMethods(array('find'))
                ->getMock();

        $this->dataFetcherRegistry =
            $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistry')
                ->disableOriginalConstructor()
                ->getMock();

        $this->htmlConverterRegistry =
            $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterRegistry')
                ->disableOriginalConstructor()
                ->getMock();

        $this->twig =
            $this->getMockBuilder('\Twig_Environment')
                ->disableOriginalConstructor()
                ->getMock();
    }


    /**
     * generateConfig
     */
    public function generateConfig()
    {
        //template
        $this->template =
            $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\Entity\Template')
                ->disableOriginalConstructor()
                ->getMock();

        $this->template
            ->expects($this->any())
            ->method('getMergeTags')
            ->will($this->returnValue(array(
                (new MergeTag())->setRequired(false),
                (new MergeTag())->setRequired(true),
            )));

        //templateManager
        $this->templateManager
            ->expects($this->any())
            ->method('find')
            ->will($this->returnValue(
                $this->template
            ));

        //htmlConverter
        $this->htmlConverterRegistry
            ->expects($this->any())
            ->method('hasHtmlConverter')
            ->will($this->returnValue(true));

        $this->htmlConverterRegistry
            ->expects($this->any())
            ->method('getHtmlConverter')
            ->will($this->returnValue(
                $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterInterface')
                    ->disableOriginalConstructor()
                    ->getMock()
            ));
    }

    /**
     * testGenerate
     */
    public function testGenerate()
    {
        $this->generateConfig();

        //dataFetcher
        $this->dataFetcherRegistry
            ->expects($this->any())
            ->method('hasDataFetcher')
            ->will($this->returnValue(true));

        $this->dataFetcherRegistry
            ->expects($this->any())
            ->method('getDataFetcher')
            ->will($this->returnValue(
                $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherInterface')
                    ->disableOriginalConstructor()
                    ->getMock()
            ));

        $generator = new Generator(
            $this->templateManager,
            $this->dataFetcherRegistry,
            $this->htmlConverterRegistry,
            $this->twig
        );

        $this->assertNull($generator->generate('0', array(), array('format'=>'html'), false));
    }

    /**
     * testGenerate
     */
    public function testPreview()
    {
        $this->generateConfig();

        //dataFetcher
        $this->dataFetcherRegistry
            ->expects($this->any())
            ->method('hasDataFetcher')
            ->will($this->returnValue(true));

        $generator = new Generator(
            $this->templateManager,
            $this->dataFetcherRegistry,
            $this->htmlConverterRegistry,
            $this->twig
        );

        $this->assertNull($generator->generate('0', array(), array('format'=>'html'), true));
    }
    /**
     * @expectedException \RuntimeException
     */
    public function testRuntimeException()
    {
        $this->generateConfig();

        $dataFetcher =
            $this->getMockBuilder('Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherInterface')
                ->disableOriginalConstructor()
                ->getMock();

        $dataFetcher
            ->expects($this->any())
            ->method('fetch')
            ->will(
                $this->throwException(new MissingGenerationParametersException())
            );

        //dataFetcherRegistry
        $this->dataFetcherRegistry
            ->expects($this->any())
            ->method('hasDataFetcher')
            ->will($this->returnValue(true));

        $this->dataFetcherRegistry
            ->expects($this->any())
            ->method('getDataFetcher')
            ->will($this->returnValue(
                $dataFetcher
            ));

        $generator = new Generator(
            $this->templateManager,
            $this->dataFetcherRegistry,
            $this->htmlConverterRegistry,
            $this->twig
        );

        $this->assertNull($generator->generate('0', array(), array('format'=>'html'), false));
    }


    /**
     * @expectedException \UnexpectedValueException
     */
    public function testUnexpectedValueExceptionWhenNoDataFetcher()
    {
        $this->generateConfig();

        //dataFetcher
        $this->dataFetcherRegistry
            ->expects($this->any())
            ->method('hasDataFetcher')
            ->will($this->returnValue(false));

        $generator = new Generator(
            $this->templateManager,
            $this->dataFetcherRegistry,
            $this->htmlConverterRegistry,
            $this->twig
        );

        $generator->generate('0', array(), array('format'=>'html'), false);
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testUnexpectedValueExceptionWhenNoTemplate()
    {
        $this->templateManager
            ->expects($this->once())
            ->method('find')
            ->will($this->returnValue(false));

        $generator = new Generator(
            $this->templateManager,
            $this->dataFetcherRegistry,
            $this->htmlConverterRegistry,
            $this->twig
        );

        $generator->generate('0', array(), array(), false);
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testUnexpectedValueExceptionWhenNoHtmlConverter()
    {
        $this->templateManager
            ->expects($this->once())
            ->method('find')
            ->will($this->returnValue(new Template()));

        $this->htmlConverterRegistry
            ->expects($this->once())
            ->method('hasHtmlConverter')
            ->will($this->returnValue(false));

        $generator = new Generator(
            $this->templateManager,
            $this->dataFetcherRegistry,
            $this->htmlConverterRegistry,
            $this->twig
        );

        $generator->generate('0', array(), array('format'=>'html'), false);
    }

    /**
     * @expectedException \Exception
     */
    public function testTwigErrorRuntime()
    {
        $this->templateManager
            ->expects($this->once())
            ->method('find')
            ->will($this->returnValue(new Template()));

        $this->twig
            ->expects($this->once())
            ->method('render')
            ->will($this->throwException(new Twig_Error_Runtime('ERROR')));

        $generator = new Generator(
            $this->templateManager,
            $this->dataFetcherRegistry,
            $this->htmlConverterRegistry,
            $this->twig
        );

        $generator->generate('0', array(), array('format'=>'html'), false);
    }

    /**
     * @expectedException \Exception
     */
    public function testTwigError()
    {
        $this->templateManager
            ->expects($this->once())
            ->method('find')
            ->will($this->returnValue(new Template()));

        $this->twig
            ->expects($this->once())
            ->method('render')
            ->will($this->throwException(new Twig_Error('ERROR')));

        $generator = new Generator(
            $this->templateManager,
            $this->dataFetcherRegistry,
            $this->htmlConverterRegistry,
            $this->twig
        );

        $generator->generate('0', array(), array('format'=>'html'), false);
    }
}
