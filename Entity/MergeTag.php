<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

/**
 * @ORM\Entity()
 * @ORM\Table(name="merge_tag")
 */
class MergeTag
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
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

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

    public function __construct()
    {
    }

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

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate(Template $template)
    {
        $this->template = $template;

        return $this;
    }
}
