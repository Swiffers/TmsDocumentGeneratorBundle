<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadatableInterface;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata;
use Tms\Bundle\MediaClientBundle\Entity\Media;

/**
 * Template
 *
 * @ORM\Table(name="template")
 * @ORM\Entity(repositoryClass="Tms\Bundle\DocumentGeneratorBundle\Entity\Repository\TemplateRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Template implements MetadatableInterface, LoggableInterface
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
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=128)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="html", type="text")
     */
    private $html;

    /**
     * @var string
     *
     * @ORM\Column(name="css", type="text")
     */
    private $css;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @var array<Metadata>
     *
     * @ORM\ManyToMany(targetEntity="IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata", cascade={"all"})
     * @ORM\JoinTable(name="template_tag",
     *      joinColumns={@ORM\JoinColumn(name="template_id", referencedColumnName="id", onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", unique=true, onDelete="cascade")}
     * )
     */
    private $tags;

    /**
     * @var array<MergeTag>
     * 
     * @ORM\OneToMany(targetEntity="MergeTag", mappedBy="template_id", cascade={"all"})
     */
    private $mergeTags;

    /**
     * @var array<Media>
     * 
     * @ORM\ManyToMany(targetEntity="Tms\Bundle\MediaClientBundle\Entity\Media", cascade={"all"})
     * @ORM\JoinTable(name="template_media",
     *      joinColumns={@ORM\JoinColumn(name="template_id", referencedColumnName="id", onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id", unique=true, onDelete="cascade")}
     * )
     */
    private $images;

    /**
     * @ORM\PrePersist()
     */
    public function onCreate()
    {
        $now = new \DateTime("now");
        $this
            ->setCreatedAt($now)
            ->setUpdatedAt($now)
        ;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function onUpdate()
    {
        $this->setUpdatedAt(new \DateTime("now"));
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mergeTags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Template
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Template
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
     * {@inheritdoc}
     */
    public function getMetadatas()
    {
        $this->getTags();
    }

}