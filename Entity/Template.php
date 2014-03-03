<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadatableInterface;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;
use Tms\Bundle\DocumentGeneratorBundle\Exception\WrongParametersException;
use Tms\Bundle\DocumentGeneratorBundle\Exception\IdentifierRequiredException;
use Tms\Bundle\DocumentGeneratorBundle\Entity\ConfigurationTag;
use Symfony\Component\HttpFoundation\Request;

/**
 * @ORM\Entity(repositoryClass="Tms\Bundle\DocumentGeneratorBundle\Entity\Repository\TemplateRepository")
 * @ORM\Table(name="template")
 * @ORM\HasLifecycleCallbacks()
 */
class Template implements MetadatableInterface, LoggableInterface
{
    const CONFIGURATION_MIRROR_LINK = 'mirror_link';    // Mirror Link Configuration Tag Alias

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
     * @ORM\Column(type="string", nullable=false)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var text
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $html;

    /**
     * @var text
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $css;

    /**
     * @var datetime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdOn;

    /**
     * @var array<Metadata>
     *
     * @ORM\ManyToMany(targetEntity="IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata", cascade={"all"})
     * @ORM\JoinTable(name="template_tag",
     *     joinColumns={@ORM\JoinColumn(name="template_id", referencedColumnName="id", onDelete="cascade")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", unique=true, onDelete="cascade")}
     * )
     */
    private $tags;

    /**
     * @var array<MergeTag>
     *
     * @ORM\OneToMany(targetEntity="MergeTag", mappedBy="template", cascade={"persist"})
     */
    private $mergeTags;

    /**
     * @var array<Media>
     *
     * @ORM\ManyToMany(targetEntity="Tms\Bundle\MediaClientBundle\Entity\Media", cascade={"all"})
     * @ORM\JoinTable(name="template_media",
     *     joinColumns={@ORM\JoinColumn(name="template_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $images;

    /**
     * @var array<ConfigurationTag>
     *
     * @ORM\ManyToMany(targetEntity="ConfigurationTag", cascade={"all"})
     * @ORM\JoinTable(name="template_configuration_tag",
     *     joinColumns={@ORM\JoinColumn(name="template_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="configuration_tag_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $configurationTags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags              = new ArrayCollection();
        $this->images            = new ArrayCollection();
        $this->configurationTags = new ArrayCollection();

        $now = new \DateTime();
        $this->setCreatedOn($now);
        $this->setSalt(md5($now->format('YmdHis')));
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadatas()
    {
        return $this->getTags();
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
     * Add configuration tags if needed
     *
     * @param array $parameters
     * @param Request $request
     * @return array
     */
    public function configure(array $parameters, Request $request)
    {
        foreach ($this->configurationTags as $configurationTag) {
            if (self::CONFIGURATION_MIRROR_LINK === $configurationTag->getAlias()) {
                $parameters[self::CONFIGURATION_MIRROR_LINK] = $request->getUri();
            }
        }

        return $parameters;
    }

    /**
     * Return the identifiers with their values
     *
     * @param array $parameters
     * @throws WrongParametersException
     * @throws IdentifierRequiredException
     * @return array
     */
    public function bind(array $parameters)
    {
        $indexedMergeTags = array();
        foreach ($this->getMergeTags() as $mergeTag) {
            $indexedMergeTags[$mergeTag->getIdentifier()] = $mergeTag;
        }
        $indexedConfigurationTags = array();
        foreach ($this->getConfigurationTags() as $configurationTag) {
            $indexedConfigurationTags[$configurationTag->getIdentifier()] = $configurationTag;
        }

        if (count(array_diff_key($parameters, $indexedMergeTags + $indexedConfigurationTags))) {
            throw new WrongParametersException();
        }

        /* Checks for each defined mergeTag in the template if the identifier is required.
         * If not and it is not passed in parameters, its value becomes empty.
        */
        $boundParameters = array();
        foreach ($indexedMergeTags as $identifier => $mergeTag) {
            if ($mergeTag->isRequired() && !isset($parameters[$identifier])) {
                throw new IdentifierRequiredException($mergeTag->getName());
            }
            $value = isset($parameters[$identifier]) ? $parameters[$identifier] : '';
            $boundParameters[$identifier] = $value;
        }
        foreach ($indexedConfigurationTags as $identifier => $configurationTag) {
            $value = isset($parameters[$identifier]) ? $parameters[$identifier] : '';
            $boundParameters[$identifier] = $value;
        }

        return $boundParameters;
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
     * Set name
     *
     * @param string $name
     * @return Template
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Template
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Template
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
     * Set html
     *
     * @param string $html
     * @return Template
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get html
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set css
     *
     * @param string $css
     * @return Template
     */
    public function setCss($css)
    {
        $this->css = $css;

        return $this;
    }

    /**
     * Get css
     *
     * @return string
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * Add mergeTag
     *
     * @param \Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag $mergeTag
     * @return Template
     */
    public function addMergeTag(\Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag $mergeTag)
    {
        $this->mergeTags[] = $mergeTag;

        return $this;
    }

    /**
     * Remove mergeTag
     *
     * @param \Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag $mergeTag
     */
    public function removeMergeTag(\Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag $mergeTag)
    {
        $this->mergeTags->removeElement($mergeTag);
    }

    /**
     * Get mergeTags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMergeTags()
    {
        return $this->mergeTags;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     * @return Template
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Add image
     *
     * @param \Tms\Bundle\MediaClientBundle\Entity\Media $image
     * @return Template
     */
    public function addImage(\Tms\Bundle\MediaClientBundle\Entity\Media $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \Tms\Bundle\MediaClientBundle\Entity\Media $image
     */
    public function removeImage(\Tms\Bundle\MediaClientBundle\Entity\Media $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add Configuration Tag
     *
     * @param \Tms\Bundle\DocumentGeneratorBundle\Entity\ConfigurationTag $configurationTag
     * @return Template
     */
    public function addConfigurationTag(\Tms\Bundle\DocumentGeneratorBundle\Entity\ConfigurationTag $configurationTag)
    {
        $this->configurationTags[] = $configurationTag;

        return $this;
    }

    /**
     * Remove Configuration Tag
     *
     * @param \Tms\Bundle\DocumentGeneratorBundle\Entity\ConfigurationTag $configurationTag
     */
    public function removeConfigurationTag(\Tms\Bundle\DocumentGeneratorBundle\Entity\ConfigurationTag $configurationTag)
    {
        $this->configurationTags->removeElement($configurationTag);
    }

    /**
     * Get Configuration Tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConfigurationTags()
    {
        return $this->configurationTags;
    }

    /**
     * Has Configuration Tag
     *
     * @param string $alias
     */
    public function hasConfigurationTag(ConfigurationTag $configurationTag)
    {
        foreach ($this->configurationTags as $templateConfigurationTag) {
            if ($templateConfigurationTag->getId() === $configurationTag->getId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Set Configuration Tags
     *
     * @param ConfigurationTag $configurationTag
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\Template
     */
    public function setConfigurationTags(ConfigurationTag $configurationTag)
    {
        $this->addConfigurationTag($configurationTag);

        return $this;
    }

    /**
     * Add tag
     *
     * @param \IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata $tag
     * @return Template
     */
    public function addTag(\IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata $tag
     */
    public function removeTag(\IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}
