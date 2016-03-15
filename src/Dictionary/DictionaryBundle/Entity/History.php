<?php

namespace Dictionary\DictionaryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * History
 *
 * @ORM\Table(name="history", indexes={@ORM\Index(name="IDX_E80749D7E357438D", columns={"word_id"}), @ORM\Index(name="IDX_E80749D7A76ED395", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="Dictionary\DictionaryBundle\Repositories\HistoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class History
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_search", type="datetime", nullable=false)
     */
    private $lastSearch;

    /**
     * @var integer
     *
     * @ORM\Column(name="hits", type="integer", nullable=false)
     */
    private $hits;

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
     * Set word
     *
     * @param Word $word
     * @return history
     */
    public function setWord($word)
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
     * Set word
     *
     * @param User $user
     * @return history
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Word
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set created
     *
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
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @return history
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
     * Set lastSearch
     *
     * @return History
     *
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function setLastSearch()
    {
        $this->lastSearch = new \DateTime();

        return $this;
    }

    /**
     * Get lastSearch
     *
     * @return \DateTime
     */
    public function getLastSearch()
    {
        return $this->lastSearch;
    }

    /**
     * Set hits
     *
     * @param integer $hits
     * @return History
     */
    public function setHits($hits)
    {
        $this->hits = $hits;

        return $this;
    }

    /**
     * Get hits
     *
     * @return integer
     */
    public function getHits()
    {
        return $this->hits;
    }
}
