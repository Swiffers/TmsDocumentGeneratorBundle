<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="template")
 */
class Template
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

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
     * @var array<Metadata>
     *
     * @ORM\ManyToMany(targetEntity="IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata", cascade={"all"})
     * @ORM\JoinTable(name="template_metadata",
     *     joinColumns={@ORM\JoinColumn(name="template_id", referencedColumnName="id", onDelete="cascade")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="metadata_id", referencedColumnName="id", unique=true, onDelete="cascade")}
     * )
     */
    private $tags;

    /**
     * @var array<MergeTag>
     *
     * @ORM\OneToMany(targetEntity="MergeTag", mappedBy="template")
     */
    private $mergeTags;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
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

    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\Template
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *
     * @param \DateTime $createdAt
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\Template
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     *
     * @param \DateTime $updatedAt
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\Template
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @param text $description
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\Template
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getHtml()
    {
        return $this->html;
    }

    /**
     *
     * @param text $html
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\Template
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    public function getCss()
    {
        return $this->css;
    }

    /**
     *
     * @param text $css
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\Template
     */
    public function setCss($css)
    {
        $this->css = $css;

        return $this;
    }

    public function getMergeTags()
    {
        return $this->mergeTags;
    }

    public function getTags()
    {
        return $this->tags;
    }
}
