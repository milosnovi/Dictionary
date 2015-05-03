<?php

namespace Dictionary\DictionaryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Piles
 *
 * @ORM\Table(name="Piles", indexes={@ORM\Index(name="IDX_28540D7FE357438D", columns={"word_id"}), @ORM\Index(name="IDX_28540D7FA76ED395", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="Dictionary\DictionaryBundle\Entity\PilesRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Piles
{

    const TYPE_KNOW         = 1;
    const TYPE_NOT_SURE     = 2;
    const TYPE_DO_NOT_KNOW  = 4;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Word
     *
     * @ORM\ManyToOne(targetEntity="Word")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="word_id", referencedColumnName="id")
     * })
     */
    private $word;


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
     * Set type
     *
     * @param integer $type
     * @return Piles
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
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
     * Set word
     *
     * @param Word $word
     * @return Piles
     */
    public function setWord(Word $word = null)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return Word
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Piles
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

}
