<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Generator;

// use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;
use Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterRegistryInterface;
use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistryInterface;

class Generator implements GeneratorInterface
{
    /**
     * @var HtmlConverterRegistryInterface
     */
    private $htmlConverterRegistry;

    /**
     * @var DataFetcherRegistryInterface
     */
    private $dataFetcherRegistry;

    /**
     * Constructor
     *
     * @param HtmlConverterRegistryInterface $htmlConverterRegistry
     * @param DataFetcherRegistryInterface   $dataFetcherRegistry
     */
    public function __construct(
        HtmlConverterRegistryInterface $htmlConverterRegistry,
        DataFetcherRegistryInterface   $dataFetcherRegistry
    )
    {
        // TODO:
    }

    /**
     * {@inheritDoc}
     */
    public function generate($template_id, array $data = array(), array $options = array())
    {
        // TODO: look at the sequence diagram
    }

    /**
     * Returns the rendered Html
     *
     * @param Template $template    The template.
     * @param array    $fetchedData The fetched data.
     *
     * @return string
     */
    private function render(Template $template, array $fetchedData)
    {
        // TODO: Use twig engine to merge the template with fetched data.
    }
}