<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Generator;

use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;
use Tms\Bundle\DocumentGeneratorBundle\Manager\TemplateManager;
use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistryInterface;
use Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterRegistryInterface;

class Generator implements GeneratorInterface
{
    /**
     * @var TemplateManager
     */
    private $templateManager;

    /**
     * @var DataFetcherRegistryInterface
     */
    private $dataFetcherRegistry;

    /**
     * @var HtmlConverterRegistryInterface
     */
    private $htmlConverterRegistry;

    /**
     * Constructor
     *
     * @param TemplateManager                $templateManager
     * @param HtmlConverterRegistryInterface $htmlConverterRegistry
     * @param DataFetcherRegistryInterface   $dataFetcherRegistry
     */
    public function __construct(
        TemplateManager                $templateManager,
        DataFetcherRegistryInterface   $dataFetcherRegistry,
        HtmlConverterRegistryInterface $htmlConverterRegistry
    )
    {
        $this->templateManager       = $templateManager;
        $this->dataFetcherRegistry   = $dataFetcherRegistry;
        $this->htmlConverterRegistry = $htmlConverterRegistry;
    }

    /**
     * {@inheritDoc}
     */
    public function generate($template_id, array $data = array(), array $options = array(), $isPreview = false)
    {
        $template = $this->templateManager->find($template_id);
        if (!$template) {
            throw new \UnexpectedValueException("Template id: ".$template_id." doesn't exist");
        }

        $fetchedData = array();
        if (!$isPreview) {
            $fetchedData = $this->fetchData($template);
        }

        $html = $this->render($template, $fetchedData, $isPreview);

        $format = $options['format'];
        if (!$this->htmlConverterRegistry->hasHtmlConverter($format)) {
            throw new \UnexpectedValueException("Format: ".$format." doesn't exist");
        }

        return $this->htmlConverterRegistry->getHtmlConverter($format)->convert($html);
    }

    /**
     * Returns the fetch data
     *
     * @param Template $template The document template.
     *
     * @return mixed
     */
    protected function fetchData(Template $template)
    {
        $fetchedData = array();
        foreach ($template->getMergeTags() as $mergeTag) {
            $identifier = $mergeTag->getIdentifier();
            $fetcherAlias = $mergeTag->getFetcherAlias();

            if (!$this->dataFetcherRegistry->hasDataFetcher($fetcherAlias)) {
                throw new \UnexpectedValueException("Fetcher alias: ".$fetcherAlias." doesn't exist");
            }

            $fetchedData[$identifier] = $this->dataFetcherRegistry
                ->getDataFetcher($fetcherAlias)
                ->fetch($data, $mergeTag->getRequired(), $mergeTag->getDefaultValue())
            ;
        }

        return $fetchedData;
    }

    /**
     * Returns the rendered Html
     *
     * @param Template $template    The template.
     * @param array    $fetchedData The fetched data.
     * @param boolean  $isPreview   If the generation must not fetch the given data.
     *
     * @return string
     */
    private function render(Template $template, array $fetchedData, $isPreview = false)
    {
        if ($isPreview) {
            return sprintf(
                "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><style type=\"text/css\">%s</style></head><body>%s</body></html>",
                $template->getCss(),
                $template->getHtml()
            );
        }

        die('TODO');
        // TODO: Use twig engine to merge the template with fetched data.
    }
}