<?php

namespace Dictionary\DictionaryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eng2srb
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dictionary\DictionaryBundle\Entity\Eng2srbRepository")
 */
class Eng2srb
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
     * @param \DateTime $created
     * @return eng2srb
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
     * @return eng2srb
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
}
