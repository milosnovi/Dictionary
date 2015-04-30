<?php

namespace Dictionary\DictionaryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Word
 *
 * @ORM\Table(name="word", indexes={@ORM\Index(name="search_index_word", columns={"name"})})
 * @ORM\Entity
 */
class Word
{

	const WORD_ENGLISH 		    = 1;
	const WORD_SERBIAN 		    = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity="Piles", mappedBy="word")
     *
     * @var ArrayCollection $engTranslate
     */
    private $piles;

    /**
     * @ORM\OneToMany(targetEntity="Eng2srb", mappedBy="eng")
     *
     * @var ArrayCollection $engTranslate
     */
    private $engTranslate;

    /**
     * @ORM\OneToMany(targetEntity="Eng2srb", mappedBy="srb")
     *
     * @var ArrayCollection $$engTranslate
     */
    private $srbTranslate;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->engTranslate = new ArrayCollection();
        $this->srbTranslate = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Word
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
     * Set name
     *
     * @param string $type
     * @return Word
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set pile
     *
     * @param integer $pile
     * @return Word
     */
    public function setPile($pile)
    {
        $this->pile = $pile;

        return $this;
    }

    /**
     * Get pile
     *
     * @return integer
     */
    public function getPile()
    {
        return $this->pile;
    }

    /**
     * Set favorite
     *
     * @param integer $favorite
     * @return Word
     */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;

        return $this;
    }

    /**
     * Get favorite
     *
     * @return integer
     */
    public function getFavorite()
    {
        return $this->favorite;
    }

    /**
     * Set created
     *
     * @return Word
     * @ORM\PrePersist
     */
    public function setCreated()
    {
        $this->created = new \DateTime();

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @return Word
     *
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function setUpdated()
    {
        $this->updated = new \DateTime();

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add $engTranslate
     *
     * @param Eng2srb $engTranslate
     * @return English
     */
    public function addEngTranslate(Eng2srb $engTranslate)
    {
        $this->engTranslate[] = $engTranslate;

        return $this;
    }

    /**
     * Remove $engTranslate
     *
     * @param Eng2srb $engTranslate
     */
    public function removeEngTranslate(Eng2srb $engTranslate)
    {
        $this->engTranslate->removeElement($$engTranslate);
    }

    /**
     * Get $engTranslate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEngTranslate()
    {
        return $this->engTranslate;
    }

    /**
     * Add srbTranslate
     *
     * @param \Dictionary\DictionaryBundle\Entity\Eng2srb $srbTranslate
     * @return Word
     */
    public function addSrbTranslate(\Dictionary\DictionaryBundle\Entity\Eng2srb $srbTranslate)
    {
        $this->srbTranslate[] = $srbTranslate;

        return $this;
    }

    /**
     * Remove srbTranslate
     *
     * @param \Dictionary\DictionaryBundle\Entity\Eng2srb $srbTranslate
     */
    public function removeSrbTranslate(\Dictionary\DictionaryBundle\Entity\Eng2srb $srbTranslate)
    {
        $this->srbTranslate->removeElement($srbTranslate);
    }

    /**
     * Get srbTranslate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSrbTranslate()
    {
        return $this->srbTranslate;
    }

    /**
     * Add piles
     *
     * @param \Dictionary\DictionaryBundle\Entity\Piles $piles
     * @return Word
     */
    public function addPile(\Dictionary\DictionaryBundle\Entity\Piles $piles)
    {
        $this->piles[] = $piles;

        return $this;
    }

    /**
     * Remove piles
     *
     * @param \Dictionary\DictionaryBundle\Entity\Piles $piles
     */
    public function removePile(\Dictionary\DictionaryBundle\Entity\Piles $piles)
    {
        $this->piles->removeElement($piles);
    }

    /**
     * Get piles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPiles()
    {
        return $this->piles;
    }

}
