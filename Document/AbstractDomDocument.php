<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Document;

use Tms\Bundle\DocumentGeneratorBundle\Generator\GeneratorInterface;
use Tms\Bundle\DocumentGeneratorBundle\Exception\IdentifierNotFoundException;
use Tms\Bundle\DocumentGeneratorBundle\Exception\IdentifierRequiredException;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

abstract class AbstractDomDocument implements RendererInterface
{
    protected $template;                        // Template used to generate the document
    protected $generator;                       // Generator service used to generate the document
    protected $mergeTags;                       // Merge Tags of the document
    protected static $identifierModel = '{%s}'; // Model used to find identifiers

    /**
     * Constructor
     *
     * @param Template           $template
     * @param GeneratorInterface $generator
     */
    public function __construct(Template $template, GeneratorInterface $generator)
    {
        $this->template = $template;
        $this->generator = $generator;
        $this->mergeTags = array();
        foreach ($this->template->getMergeTags() as $mergeTag) {
            $this->mergeTags[$mergeTag->getIdentifier()] = $mergeTag;
        }
    }

    /**
     * Render the DOM binded with the given parameters
     *
     * @param array $parameters
     * @return text
     */
    public function renderDom(array $parameters)
    {
        $body = '';
        $html = $this->template->getHtml();
        if (empty($html)) {
            return $body;
        }

        $bindedIdentifiers = $this->bindIdentifiers($parameters);
        $body .= str_replace($bindedIdentifiers['identifiers'], $bindedIdentifiers['values'], $html);

        if (false === strpos($body, 'utf-8')) {
            $metaCharset = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n\t";
            $insertPosition = strpos($body, '</head>');
            $body = substr_replace($body, $metaCharset, $insertPosition, 0);
        }

        $css = $this->template->getCss();
        if (!empty($css)) {
            $insertPosition = strpos($body, '</head>');
            $body = substr_replace($body, "<style type=\"text/css\">\n" . $css . "</style>\n", $insertPosition, 0);
        }

        return $body;
    }

    /**
     * Return the identifiers with their values
     *
     * @param array $parameters
     * @throws IdentifierRequiredException
     * @throws IdentifierNotFoundException
     * @return array
     */
    private function bindIdentifiers(array $parameters)
    {
        $identifiers = array();
        $values = array();

        // Check for each defined mergeTag in the template if the identifier is required, and if not and its is not passed in parameters, its value becomes empty
        foreach ($this->mergeTags as $mergeTag) {
            if (!array_key_exists($mergeTag->getIdentifier(), $parameters)) {
                if (true === $mergeTag->isRequired()) {
                    throw new IdentifierRequiredException($mergeTag->getName());
                } else {
                    array_push($identifiers, sprintf(self::$identifierModel, $mergeTag->getIdentifier()));
                    array_push($values, '');
                }
            }
        }

        // Check for each merge tag passed in parameters if the identifier is found in the defined merge tags of the template
        foreach ($parameters as $identifier => $value) {
            if (!array_key_exists($identifier, $this->mergeTags)) {
                throw new IdentifierNotFoundException($identifier);
            }
            array_push($identifiers, sprintf(self::$identifierModel, $identifier));
            array_push($values, $value);
        }

        return array(
            'identifiers' => $identifiers,
            'values'      => $values
        );
    }
}
