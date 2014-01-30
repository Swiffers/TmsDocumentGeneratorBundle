<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Document;

use Tms\Bundle\DocumentGeneratorBundle\Generator\GeneratorInterface;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

class DomDocument
{
    protected $generator; // Generator service used to generate the document
    
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
        if (!strlen($template->getHtml())) {
            return '';
        }

        $html = self::initHtml();

        $content = sprintf(
            $html,
            $template->getCss(),
            $template->getHtml()
        );

        $loader = new \Twig_Loader_String();
        $twig = new \Twig_Environment($loader);

        return $twig->render($content, $template->bind($parameters));
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
