<?php

namespace Acme\DemoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * English
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Acme\DemoBundle\Entity\EnglishRepository")
 */
class English
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
     * @ORM\Column(name="word", type="string", length=255)
     */
    private $word;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="eng2srb", mappedBy="enId")
     *
     * @var ArrayCollection $translate
     */
    private $translate;


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
     * Set word
     *
     * @param string $word
     * @return English
     */
    public function setWord($word)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return string 
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return English
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
     * Constructor
     */
    public function __construct()
    {
        $this->translate = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add translate
     *
     * @param \Acme\DemoBundle\Entity\eng2srb $translate
     * @return English
     */
    public function addTranslate(\Acme\DemoBundle\Entity\eng2srb $translate)
    {
        $this->translate[] = $translate;

        return $this;
    }

    /**
     * Remove translate
     *
     * @param \Acme\DemoBundle\Entity\eng2srb $translate
     */
    public function removeTranslate(\Acme\DemoBundle\Entity\eng2srb $translate)
    {
        $this->translate->removeElement($translate);
    }

    /**
     * Get translate
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTranslate()
    {
        return $this->translate;
    }
}
