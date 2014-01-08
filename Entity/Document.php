<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="document")
 */
class Document
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
     * @var text
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @var array<Tag>
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="documents")
     * @ORM\JoinTable(name="document_tag")
     */
    private $tags;

    /**
     * @var array<MergeTag>
     *
     * @ORM\OneToMany(targetEntity="MergeTag", mappedBy="document")
     */
    private $mergeTags;

    public function __construct()
    {
        $this->tags      = new ArrayCollection();
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

    public function getTags()
    {
        return $this->tags;
    }

    public function getMergeTags()
    {
        return $this->mergeTags;

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
}
