<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Generator;

use \Twig_Environment;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;
use Tms\Bundle\DocumentGeneratorBundle\Handler\JsonHandler;
use Tms\Bundle\DocumentGeneratorBundle\Manager\TemplateManager;
use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistryInterface;
use Tms\Bundle\DocumentGeneratorBundle\HtmlConverter\HtmlConverterRegistryInterface;

use Tms\Bundle\DocumentGeneratorBundle\Exception\MissingGenerationParametersException;

/**
 * Class Generator
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\Generator
 */
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
     * @param DataFetcherRegistryInterface   $dataFetcherRegistry
     * @param HtmlConverterRegistryInterface $htmlConverterRegistry
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
            throw new \UnexpectedValueException(sprintf(
                "UnexpectedValueException - Template id: %s doesn't exist",
                $templateId
            ));
        }

        $fetchedData = array();
        if (!$isPreview) {
            $fetchedData = $this->fetchData($template, $data);
        }

        $html = $this->render($template, $fetchedData, $isPreview);

        $format = $options['format'];

        if (!$this->htmlConverterRegistry->hasHtmlConverter($format)) {
            throw new \UnexpectedValueException(sprintf(
                "UnexpectedValueException - Format: %s doesn't exist",
                $format
            ));
        }

        return $this->htmlConverterRegistry->getHtmlConverter($format)->convert($html);
    }

    /**
     * Loop on every merge tag to fetch data
     *
     * @param Template $template The document template.
     * @param array    $data     The data(with parameters used by fetcher to fetch data for each merge tag of the template).
     *
     * @return array
     *
     * @throws \UnexpectedValueException When a merge tag use one fetcher alias unregistered.
     * @throws \RuntimeException         Previous: MissingGenerationParametersException.
     *                                   For a merge tag required,
     *                                   When his parameters witch is used by fetcher cannot be found in the data.
     */
    private function fetchData(Template $template, $data)
    {
        $fetchedData = array();

        foreach ($template->getMergeTags() as $mergeTag) {
            $identifier = $mergeTag->getIdentifier();
            $fetcherAlias = $mergeTag->getFetcherAlias();

            if (!$this->dataFetcherRegistry->hasDataFetcher($fetcherAlias)) {
                throw new \UnexpectedValueException(sprintf(
                    "UnexpectedValueException - Fetcher alias: %s doesn't exist",
                    $fetcherAlias
                ));
            }

            try {
                $fetchedData[$identifier] = $this->dataFetcherRegistry
                    ->getDataFetcher($fetcherAlias)
                    ->fetch($data, $mergeTag);
            } catch (MissingGenerationParametersException $e) {
                if ($mergeTag->isRequired()) {
                    throw new \RuntimeException(sprintf(
                        "MissingGenerationParametersException - The parameter: '%s' is required",
                        $mergeTag->getIdentifier()
                    ));
                }

                //DefaultValue could be a string of json
                $fetchedData[$identifier] = JsonHandler::is_json($mergeTag->getDefaultValue(), true, true)
                    ?
                    : $mergeTag->getDefaultValue();
            }
        }

        return $fetchedData;
    }

    /**
     * Using twig render(with string loader) to fuse fetchedData and twig template
     * Returns the rendered Html
     *
     * @param Template $template    The template.
     * @param array    $fetchedData The fetched data.
     * @param boolean  $isPreview   If in the mode preview.
     *
     * @return string
     *
     * @throws \Exception Previous: Twig_Error_Loader, Twig_Error_Syntax, Twig_Error_Runtime.
     *                    Twig render error.
     */
    private function render(Template $template, array $fetchedData, $isPreview = false)
    {
        echo '<pre>';
        print_r($fetchedData);
        echo '</pre>';

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
            throw new \Exception(sprintf(
                "%s - Render: %s, this exception was raised may be you use a merge tag not defined in the template: %s",
                get_class($e),
                $e->getMessage(),
                $template->getId()
            ));
        } catch (\Twig_Error $e) {
            throw new \Exception(sprintf(
                "%s - Render: %s, template id: %s",
                get_class($e),
                $e->getMessage(),
                $template->getId()
            ));
        }

        /**
         * Clear twig cache files
         *
         *    * Twig_Loader_String
         *
         *    * When using this loader with a cache mechanism, you should know that a new cache
         *    * key is generated each time a template content "changes" (the cache key being the
         *    * source code of the template). If you don't want to see your cache grows out of
         *    * control, you need to take care of clearing the old cache file by yourself.
         */
        $this->twig->clearCacheFiles();

        return $html;
    }
}