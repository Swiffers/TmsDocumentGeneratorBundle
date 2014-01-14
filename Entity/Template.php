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
    private $body;

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

    public function getCreatedAt()
    {
        return $this->createdAt;
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

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function getMergeTags()
    {
        return $this->mergeTags;
    }
}
