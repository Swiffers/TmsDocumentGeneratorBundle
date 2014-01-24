<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use IDCI\Bundle\SimpleMetadataBundle\Metadata\MetadatableInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="template")
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

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

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->tags      = new ArrayCollection();
        $this->salt      = md5($this->createdAt->format('YmdHis'));
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
     * @param \DateTime $createdAt
     * @return \Tms\Bundle\DocumentGeneratorBundle\Entity\Template
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    /**
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
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

    /**
     * {@inheritdoc}
     */
    public function getMetadatas()
    {
        return $this->getTags();
    }

    public function getTags()
    {
        return $this->tags;
    }

    /**
     * {@inheritdoc}
     */
    public function addTag(\IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeTag(\IDCI\Bundle\SimpleMetadataBundle\Entity\Metadata $tag)
    {
        $this->tags->removeElement($tag);
    }
}
