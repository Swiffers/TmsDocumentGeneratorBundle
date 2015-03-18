<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MergeTag
 *
 * @ORM\Entity()
 * @ORM\Table(name="merge_tag")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Tms\Bundle\DocumentGeneratorBundle\Entity\Repository\MergeTagRepository")
 */
class MergeTag
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=64)
     */
    private $identifier;

    /**
     * @var boolean
     *
     * @ORM\Column(name="required", type="boolean")
     */
    private $required;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=128)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="default_value", type="string", length=255, nullable=true)
     */
    private $defaultValue;

    /**
     * @var string
     *
     * @ORM\Column(name="fetcher_alias", type="string", length=255)
     */
    private $fetcherAlias;

    /**
     * @var array
     *
     * @ORM\Column(name="fetch_data_keys", type="simple_array")
     */
    private $fetchDataKeys;

    /**
     * @var integer
     * 
     * @ORM\ManyToOne(targetEntity="Template", inversedBy="mergeTags", cascade={"persist"})
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id", nullable=false, onDelete="Cascade")
     */
    private $template_id;

    /**
     * toString
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getIdentifier();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return MergeTag
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    
        return $this;
    }

    /**
     * Get identifier
     *
     * @return string 
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set required
     *
     * @param boolean $required
     * @return MergeTag
     */
    public function setRequired($required)
    {
        $this->required = $required;
    
        return $this;
    }

    /**
     * Get required
     *
     * @return boolean 
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return MergeTag
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set defaultValue
     *
     * @param string $defaultValue
     * @return MergeTag
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    /**
     * Get defaultValue
     *
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Set fetcherAlias
     *
     * @param string $fetcherAlias
     * @return MergeTag
     */
    public function setFetcherAlias($fetcherAlias)
    {
        $this->fetcherAlias = $fetcherAlias;
    
        return $this;
    }

    /**
     * Get fetcherAlias
     *
     * @return string 
     */
    public function getFetcherAlias()
    {
        return $this->fetcherAlias;
    }

    /**
     * Set fetchDataKeys
     *
     * @param array $fetchDataKeys
     * @return MergeTag
     */
    public function setFetchDataKeys($fetchDataKeys)
    {
        $this->fetchDataKeys = $fetchDataKeys;

        return $this;
    }

    /**
     * Get fetchDataKeys
     *
     * @return array
     */
    public function getFetchDataKeys()
    {
        return $this->fetchDataKeys;
    }

    /**
     * Set templateId
     *
     * @param \Tms\Bundle\DocumentGeneratorBundle\Entity\Template $templateId
     * @return MergeTag
     */
    public function setTemplateId(\Tms\Bundle\DocumentGeneratorBundle\Entity\Template $templateId)
    {
        $this->template_id = $templateId;
    
        return $this;
    }

    /**
     * Get templateId
     *
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\Template 
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }
}