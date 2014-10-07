<?php

namespace Dictionary\DictionaryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eng2srb
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dictionary\DictionaryBundle\Entity\Eng2srbRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Eng2srb
{

    const ENG_2_SRB = 1;

    const SRB_2_ENG = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var English
     *
	 * @ORM\ManyToOne(targetEntity="Word", inversedBy="engTranslate")
	 * @ORM\JoinColumn(name="eng_id", referencedColumnName="id")
     */
    private $eng;

    /**
     * @var Serbian
     *
	 * @ORM\ManyToOne(targetEntity="Word", inversedBy="srbTranslate")
	 * @ORM\JoinColumn(name="srb_id", referencedColumnName="id")
     */
    private $srb;

    /**
     * @var integer
	 * @ORM\Column(name="relevance", type="integer")
     */
    private $relevance = '1';

    /**
     * @var integer
	 * @ORM\Column(name="direction", type="integer")
     */
    private $direction;

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
     * @ORM\preUpdate
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
}
