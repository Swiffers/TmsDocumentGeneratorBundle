<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

/**
 * @ORM\Entity()
 * @ORM\Table(name="merge_tag")
 */
class MergeTag implements LoggableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $required;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $identifier;

    /**
     * @var <Template>
     *
     * @ORM\ManyToOne(targetEntity="Template", inversedBy="mergeTags")
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id")
     */
    private $template;

    /**
     * toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param boolean $required
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param Template $template
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag
     */
    public function setTemplate(Template $template)
    {
        $this->template = $template;

        return $this;
    }
}
