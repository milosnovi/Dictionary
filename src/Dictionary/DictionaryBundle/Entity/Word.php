<?php

namespace Dictionary\DictionaryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * Word
 *
 * @ORM\Table(name="word",indexes={@index(name="search_index_word", columns={"name"})})
 * @ORM\Entity(repositoryClass="Dictionary\DictionaryBundle\Entity\WordRepository")
 */
class Word
{

	const WORD_ENGLISH 		= 1;
	const WORD_SERBIAN 		= 2;

	const WORD_TYPE_NOUN 	= 1;
	const WORD_TYPE_ADJ 	= 2;
	const WORD_TYPE_ADV 	= 4;
	const WORD_TYPE_VERB 	= 8;

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="word_type", type="integer", nullable=true)
     */
    private $wordType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
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
     * @param \DateTime $created
     * @return Word
     */
    public function setCreated($created)
    {
        $this->created = $created;

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
     * @param \DateTime $updated
     * @return Word
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

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
     * Set wordType
     *
     * @param integer $wordType
     * @return Word
     */
    public function setWordType($wordType)
    {
        $this->wordType = $wordType;

        return $this;
    }

    /**
     * Get wordType
     *
     * @return integer 
     */
    public function getWordType()
    {
        return $this->wordType;
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

    public static function wordType2String($wordType) {
        switch ($wordType) {
            case self::WORD_TYPE_NOUN:
                return 'noun';
                break;
            case self::WORD_TYPE_ADJ:
                return 'adjective';
                break;
            case self::WORD_TYPE_ADV:
                return 'adverb';
                break;
            case self::WORD_TYPE_VERB:
                return 'verb';
                break;
        }
    }
}
