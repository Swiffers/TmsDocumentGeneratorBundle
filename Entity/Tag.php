<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="tag")
 */
class Tag
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
     * @var array<Document>
     *
     * @ORM\ManyToMany(targetEntity="Document", mappedBy="tags")
     */
    private $documents;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
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
}
