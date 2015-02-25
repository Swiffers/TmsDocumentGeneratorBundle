<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;

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
     * @ORM\Column(name="fetcher_alias", type="string", length=255)
     */
    private $fetcherAlias;


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
}
