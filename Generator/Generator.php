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
    public function generate($template_id, array $data = array(), array $options = array())
    {
        $template = $this->templateManager->find($template_id);
        if (!$template) {
            throw new \UnexpectedValueException("Template id: ".$template_id." doesn't exist");
        }

        $fetchedData = array();
        if ($options['mode'] != 'preview') {
            $rawData = array();
            foreach ($template->getMergeTags() as $mergeTag) {
                $identifier = $mergeTag->getIdentifier();
                $fetcherAlias = $mergeTag->getFetcherAlias();

                if (!array_key_exists($fetcherAlias, $rawData)) {
                    if (!$this->dataFetcherRegistry->hasDataFetcher($fetcherAlias)) {
                        throw new \UnexpectedValueException("Fetcher alias: ".$fetcherAlias." doesn't exist");
                    }
                    $rawData[$fetcherAlias] = $this->dataFetcherRegistry
                        ->getDataFetcher($fetcherAlias)
                        ->fetch($data);
                }

                if (!array_key_exists($identifier, $rawData[$fetcherAlias])) {
                    if ($mergeTag->getRequired()) {
                        throw new \UnexpectedValueException(
                            "Can not find ".$identifier." on the fetcher ".$fetcherAlias
                        );
                    }
                    continue;
                }

                $fetchedData[$identifier] = $rawData[$fetcherAlias][$identifier];
            }
        }

        var_dump($fetchedData);
        $html = $this->render($template, $fetchedData);

        if (!isset($options['format']) || $options['format'] == 'html') {
            return $html;
        }

        $format = $options['format'];
        if (!$this->htmlConverterRegistry->hasHtmlConverter($format)) {
            throw new \UnexpectedValueException("Format: ".$format." doesn't exist");
        }

        return $this->htmlConverterRegistry->getHtmlConverter($format)
            ->convert($html);
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
        $initHtml = "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><style type=\"text/css\">%s</style></head><body>%s</body></html>";

        return sprintf(
            $initHtml,
            $template->getCss(),
            $template->getHtml()
        );
    }
}