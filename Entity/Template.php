<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Template
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tms\Bundle\DocumentGeneratorBundle\Entity\TemplateRepository")
 */
class Template
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
     * @var array
     *
     * @ORM\Column(name="images", type="array")
     */
    private $images;

    /**
     * @var array
     *
     * @ORM\Column(name="tags", type="array")
     */
    private $tags;


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
     * Set images
     *
     * @param array $images
     * @return Template
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return array 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set tags
     *
     * @param array $tags
     * @return Template
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return array 
     */
    public function getTags()
    {
        return $this->tags;
    }
}
