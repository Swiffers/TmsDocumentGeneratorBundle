<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Document;

use Tms\Bundle\DocumentGeneratorBundle\Generator\GeneratorInterface;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

class DomDocument
{
    protected $generator;                        // Generator service used to generate the document
    protected static $identifierFormat = '{%s}'; // Format used to find identifiers

    /**
     * Constructor
     *
     * @param GeneratorInterface $generator
     */
    public function __construct(GeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Render the DOM with the given parameters merged
     *
     * @param Template $template
     * @param array $parameters
     * @return string
     */
    public function renderDom(Template $template, array $parameters)
    {
        $body = $template->getHtml();
        if (!strlen($body)) {
            return '';
        }

        $html = self::initHtml();

        return sprintf(
            $html,
            $template->getCss(),
            $this->mergeHtmlWithParameters($body, $template->bind($parameters))
        );
    }

    /**
     * Init html dom
     *
     * @return string
     */
    private static function initHtml()
    {
        return "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><style type=\"text/css\">%s</style></head><body>%s</body></html>";
    }

    /**
     *
     * @param string $html
     * @param array $parameters
     * @return string
     */
    private function mergeHtmlWithParameters($html, array $boundIdentifiers)
    {
        return str_replace($boundIdentifiers['identifiers'], $boundIdentifiers['values'], $html);
    }

    /**
     * Format a given identifier using the identifierFormat
     *
     * @param string $identifier
     * @return string
     */
    public static function formatIdentifier($identifier)
    {
        return sprintf(self::$identifierFormat, $identifier);
    }

    /**
     * Display
     *
     * @param Template $template
     * @param array $parameters
     * @return string
     */
    public function display(Template $template, array $parameters)
    {
        $html = $this->renderDom($template, $parameters);

        return $this->generator->generate($html);
    }

    /**
     * Get MimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->generator->getMimeType();
    }
}
