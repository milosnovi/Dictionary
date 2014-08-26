<?php

namespace Dictionary\DictionaryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * history
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dictionary\DictionaryBundle\Entity\historyRepository")
 */
class history
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
     * @ORM\Column(name="eng_id", type="integer")
     */
    private $engId;

    /**
     * @var string
     *
     * @ORM\Column(name="created", type="string", length=255)
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
     * @param integer $engId
     * @return history
     */
    public function setEngId($engId)
    {
        $this->engId = $engId;

        return $this;
    }

    /**
     * Get engId
     *
     * @return integer 
     */
    public function getEngId()
    {
        return $this->engId;
    }

    /**
     * Set created
     *
     * @param string $created
     * @return history
     */
    public function setCreated($created)
    {
        $this->created = $created;

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
     * @param \DateTime $updated
     * @return history
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
