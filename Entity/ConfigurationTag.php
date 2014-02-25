<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;
use Tms\Bundle\DocumentGeneratorBundle\Entity\Template;

/**
 * @ORM\Entity()
 * @ORM\Table(name="configuration_tag")
 */
class ConfigurationTag implements LoggableInterface
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
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $identifier;

    /**
     * @var array<Template>
     *
     * @ORM\ManyToMany(targetEntity="Template", mappedBy="configurationTags")
     */
    private $templates;

    public function __construct()
    {
        $this->templates = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Get Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\ConfigurationTag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Alias
     *
     * @param string $alias
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\ConfigurationTag
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get Alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Get Identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set Identifier
     *
     * @param string $identifier
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\ConfigurationTag
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Add Template
     *
     * @param \Tms\Bundle\DocumentGeneratorBundle\Entity\Template $template
     * @return Template
     */
    public function addTemplate(\Tms\Bundle\DocumentGeneratorBundle\Entity\Template $template)
    {
        $template->addConfigurationTag($this);
        $this->templates[] = $template;

        return $this;
    }

    /**
     * Remove Template
     *
     * @param \Tms\Bundle\DocumentGeneratorBundle\Entity\Template $template
     */
    public function removeTemplate(\Tms\Bundle\DocumentGeneratorBundle\Entity\Template $template)
    {
        $template->removeConfigurationTag($this);
        $this->templates->removeElement($template);
    }

    /**
     * Get Templates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTemplates()
    {
        return $this->templates;
    }
}
