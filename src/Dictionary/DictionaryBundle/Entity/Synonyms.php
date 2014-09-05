<?php

namespace Dictionary\DictionaryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Synonyms
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dictionary\DictionaryBundle\Entity\SynonymsRepository")
 */
class Synonyms
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
     * @var Word
     *
	 * @ORM\ManyToOne(targetEntity="Word", inversedBy="synonyms")
	 * @ORM\JoinColumn(name="word_id", referencedColumnName="id")
	 */
    private $word;

    /**
     * @var Word
     *
	 * @ORM\ManyToOne(targetEntity="Word")
	 * @ORM\JoinColumn(name="synonym_id", referencedColumnName="id")
	 */
    private $synonym;

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
     * Set created
     *
     * @param \DateTime $created
     * @return Synonyms
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
     * @return Synonyms
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
     * Set word
     *
     * @param Word $word
     * @return Synonyms
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
     * Set synonym
     *
     * @param \Dictionary\DictionaryBundle\Entity\Word $synonym
     * @return Synonyms
     */
    public function setSynonym(\Dictionary\DictionaryBundle\Entity\Word $synonym = null)
    {
        $this->synonym = $synonym;

        return $this;
    }

    /**
     * Get synonym
     *
     * @return \Dictionary\DictionaryBundle\Entity\Word 
     */
    public function getSynonym()
    {
        return $this->synonym;
    }
}
