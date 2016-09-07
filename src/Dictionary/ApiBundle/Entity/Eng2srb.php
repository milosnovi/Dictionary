<?php

namespace Dictionary\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eng2srb
 *
 * @ORM\Table(name="eng2srb", indexes={@ORM\Index(name="IDX_2093BDF4F00825FE", columns={"eng_id"}), @ORM\Index(name="IDX_2093BDF4B7494EC9", columns={"srb_id"})})
 * @ORM\Entity(repositoryClass="Dictionary\ApiBundle\Repositories\Eng2srbRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Eng2srb
{

    const ENG_2_SRB = 1;

    const SRB_2_ENG = 2;

    const WORD_TYPE_NOUN 	    = 1;
    const WORD_TYPE_ADJ 	    = 2;
    const WORD_TYPE_ADV 	    = 4;
    const WORD_TYPE_VERB 	    = 8;
    const WORD_TYPE_PREPOSITION = 16;
    const WORD_TYPE_CONJUNCTION = 32;
    const WORD_TYPE_PRONOUN     = 64;
    const WORD_TYPE_ARTICLE     = 128;
    const WORD_TYPE_PARTICLE    = 256;


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @var integer
     *
     * @ORM\Column(name="relevance", type="integer", nullable=false)
     */
    private $relevance = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="direction", type="integer", nullable=false)
     */
    private $direction;

    /**
     * @var integer
     *
     * @ORM\Column(name="word_type", type="integer", nullable=false)
     */
    private $wordType;

    /**
     * @var \Word
     *
     * @ORM\ManyToOne(targetEntity="Word")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="srb_id", referencedColumnName="id")
     * })
     */
    private $srb;

    /**
     * @var \Word
     *
     * @ORM\ManyToOne(targetEntity="Word")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="eng_id", referencedColumnName="id")
     * })
     */
    private $eng;


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
     * Set engId
     *
     * @param Word $eng
     * @return eng2srb
     */
    public function setEng(Word $eng)
    {
        $this->eng = $eng;

        return $this;
    }

    /**
     * Get engId
     *
     * @return integer
     */
    public function getEng()
    {
        return $this->eng;
    }

    /**
     * Set srbId
     *
     * @param Word $srb
     * @return eng2srb
     */
    public function setSrb(Word $srb)
    {
        $this->srb = $srb;

        return $this;
    }

    /**
     * Get srbId
     *
     * @return integer
     */
    public function getSrb()
    {
        return $this->srb;
    }

    /**
     * Set created
     *
     * @return eng2srb
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
     * Set relevance
     *
     * @param integer $relevance
     * @return Eng2srb
     */
    public function setRelevance($relevance)
    {
        $this->relevance = $relevance;

        return $this;
    }

    /**
     * Get relevance
     *
     * @return integer
     */
    public function getRelevance()
    {
        return $this->relevance;
    }

    /**
     * Set direction
     *
     * @param integer $direction
     * @return Eng2srb
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return integer
     */
    public function getDirection()
    {
        return $this->direction;
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
            case self::WORD_TYPE_PREPOSITION:
                return 'preposition';
                break;
            case self::WORD_TYPE_CONJUNCTION:
                return 'conjunction';
                break;
            case self::WORD_TYPE_PRONOUN:
                return 'pronoun';
                break;
            case self::WORD_TYPE_ARTICLE:
                return 'article';
                break;
            case self::WORD_TYPE_PARTICLE:
                return 'particle';
                break;
        }
    }

    public static function getWordTypeBy($value) {
        switch ($value) {
            case 'noun':
                return self::WORD_TYPE_NOUN;
                break;
            case 'adjective':
                return self::WORD_TYPE_ADJ;
                break;
            case 'adverb':
                return self::WORD_TYPE_ADV;
                break;
            case 'verb':
                return self::WORD_TYPE_VERB;
                break;
            case 'preposition':
                return self::WORD_TYPE_PREPOSITION;
                break;
            case 'conjunction':
                return self::WORD_TYPE_CONJUNCTION;
                break;
            case 'pronoun':
                return self::WORD_TYPE_PRONOUN;
                break;
            case 'article':
                return self::WORD_TYPE_ARTICLE;
                break;
            case 'particle':
                return self::WORD_TYPE_PARTICLE;
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * Set wordType
     *
     * @param integer $wordType
     * @return Eng2srb
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
}
