<?php

namespace Acme\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * eng2srb
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Acme\DemoBundle\Entity\eng2srbRepository")
 */
class eng2srb
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="English", inversedBy="translate")
     * @ORM\JoinColumn(name="en_id", referencedColumnName="id")
     */
    private $enId;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Serbian", inversedBy="translate")
     * @ORM\JoinColumn(name="srb_id", referencedColumnName="id")
     */
    private $srbId;


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
     * Set enId
     *
     * @param English $english
     * @return eng2srb
     */
    public function setEnId(English $english)
    {
        $this->enId = $english;

        return $this;
    }

    /**
     * Get enId
     *
     * @return English
     */
    public function getEnId()
    {
        return $this->enId;
    }

    /**
     * Set srbId
     *
     * @param Serbian $serbian
     * @return eng2srb
     */
    public function setSrbId(Serbian $serbian)
    {
        $this->srbId = $serbian;

        return $this;
    }

    /**
     * Get srbId
     *
     * @return Serbian
     */
    public function getSrbId()
    {
        return $this->srbId;
    }
}
