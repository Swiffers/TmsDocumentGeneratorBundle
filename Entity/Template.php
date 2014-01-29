<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadatableInterface;
use Tms\Bundle\DocumentGeneratorBundle\Exception\WrongParametersException;
use Tms\Bundle\DocumentGeneratorBundle\Exception\IdentifierRequiredException;

/**
 * @ORM\Entity()
 * @ORM\Table(name="template")
 * @ORM\HasLifecycleCallbacks()
 */
class Template implements MetadatableInterface, LoggableInterface
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
     * @ORM\OneToMany(targetEntity="MergeTag", mappedBy="template")
     */
    private $mergeTags;

    /**
     * @var array<Media>
     *
     * @ORM\ManyToMany(targetEntity="Tms\Bundle\MediaClientBundle\Entity\Media", cascade={"all"})
     * @ORM\JoinTable(name="template_media",
     *     joinColumns={@ORM\JoinColumn(name="template_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id", unique=true, onDelete="CASCADE")}
     * )
     */
    private $images;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->images = new ArrayCollection();
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
     * Return the identifiers with their values
     *
     * @param array $parameters
     * @throws WrongParametersException
     * @throws IdentifierRequiredException
     * @return array
     */
    public function bind(array $parameters)
    {
        $identifiers = array();
        $values = array();

        $indexedMergeTags = array();
        foreach ($this->getMergeTags() as $mergeTag) {
            $indexedMergeTags[$mergeTag->getIdentifier()] = $mergeTag;
        }

        if (count(array_diff_key($parameters, $indexedMergeTags))) {
            throw new WrongParametersException();
        }

        // Check for each defined mergeTag in the template if the identifier is required, and if not and its is not passed in parameters, its value becomes empty
        foreach ($indexedMergeTags as $identifier => $mergeTag) {
            if ($mergeTag->isRequired() && !isset($parameters[$identifier])) {
                throw new IdentifierRequiredException($mergeTag->getName());
            }
            $value = isset($parameters[$identifier]) ? $parameters[$identifier] : '';
            array_push($identifiers, \Tms\Bundle\DocumentGeneratorBundle\Document\DomDocument::formatIdentifier($identifier));
            array_push($values, $value);
        }

        return array(
            'identifiers' => $identifiers,
            'values'      => $values
        );
    }

    /**
     * onCreate
     * @ORM\PrePersist()
     */
    public function onCreate()
    {
        $now = new \DateTime();
        $this->setCreatedOn($now);
        $this->setSalt(md5($now->format('YmdHis')));
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMetadatas()
    {
        return $this->getTags();
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
     * Add tags
     *
     * @param \IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata $tags
     * @return Template
     */
    public function addTag(\IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata $tags
     */
    public function removeTag(\IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata $tags)
    {
        $this->tags->removeElement($tags);
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

    /**
     * Add mergeTags
     *
     * @param \Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag $mergeTags
     * @return Template
     */
    public function addMergeTag(\Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag $mergeTags)
    {
        $this->mergeTags[] = $mergeTags;

        return $this;
    }

    /**
     * Remove mergeTags
     *
     * @param \Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag $mergeTags
     */
    public function removeMergeTag(\Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag $mergeTags)
    {
        $this->mergeTags->removeElement($mergeTags);
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
     * Get imageById
     *
     * @param integer $id
     * @return \Tms\Bundle\MediaClientBundle\Entity\Media
     */
    public function getImageById($id)
    {
        foreach ($this->images as $image) {
            if ($image->getId() === $id) {
                return $image;
            }
        }

        return null;
    }
}
