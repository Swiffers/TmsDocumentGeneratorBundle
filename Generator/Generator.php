<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Generator;

use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;
use Tms\Bundle\DocumentGeneratorBundle\Manager\TemplateManager;
use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistryInterface;
use Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterRegistryInterface;
use \Twig_Environment;

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
     * @var $twig
     */
    private $twig;

    /**
     * Constructor
     *
     * @param TemplateManager                $templateManager
     * @param HtmlConverterRegistryInterface $htmlConverterRegistry
     * @param DataFetcherRegistryInterface   $dataFetcherRegistry
     * @param Twig_Environment               $twig
     */
    public function __construct(
        TemplateManager                $templateManager,
        DataFetcherRegistryInterface   $dataFetcherRegistry,
        HtmlConverterRegistryInterface $htmlConverterRegistry,
        Twig_Environment               $twig
    )
    {
        $this->templateManager       = $templateManager;
        $this->dataFetcherRegistry   = $dataFetcherRegistry;
        $this->htmlConverterRegistry = $htmlConverterRegistry;
        $this->twig                  = $twig;
    }

    /**
     * {@inheritDoc}
     */
    public function generate($templateId, array $data = array(), array $options = array(), $isPreview = false)
    {
        $template = $this->templateManager->find($templateId);
        if (!$template) {
            throw new \UnexpectedValueException("Template id: ".$templateId." doesn't exist");
        }

        $fetchedData = array();
        if (!$isPreview) {
            $fetchedData = $this->fetchData($template, $data);
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
     * @param array    $data     The bases data to merge.
     *
     * @return mixed
     */
    protected function fetchData(Template $template, $data)
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
                ->fetch($data, $mergeTag)
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
     * @throws \Exception
     *
     * @return string
     */
    private function render(Template $template, array $fetchedData, $isPreview = false)
    {
        $html = sprintf(
            "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><style type=\"text/css\">%s</style></head><body>%s</body></html>",
            $template->getCss(),
            $template->getHtml()
        );

        if ($isPreview) {
            return $html;
        }

        try {
            $html = $this->twig->render($html, $fetchedData);
        } catch (\Twig_Error_Runtime $e) {
            throw new \Exception(get_class($e).': '.$e->getMessage().
                ', this exception was raised may be you use a merge tag not defined in the template: '.$template->getId()
            );
        } catch (\Twig_Error $e) {
            throw new \Exception(get_class($e).': '.$e->getMessage().', template id: '.$template->getId());
        }

        /**
         * Clear twig cache files
         *
         *    * Twig_Loader_String
         *    * When using this loader with a cache mechanism, you should know that a new cache
         *    * key is generated each time a template content "changes" (the cache key being the
         *    * source code of the template). If you don't want to see your cache grows out of
         *    * control, you need to take care of clearing the old cache file by yourself.
         */
        $this->twig->clearCacheFiles();

        return $html;
    }
}