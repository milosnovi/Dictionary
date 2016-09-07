<?php

namespace Dictionary\ApiBundle\Model;


use Dictionary\ApiBundle\Entity\Word;
use Doctrine\ORM\EntityManager;

class WordManager
{
    /**
     * @var $em EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function findEnglishWord($word) {
        return $this->findWord($word, Word::WORD_ENGLISH);
    }

    public function findSerbianWord($word) {
        return $this->findWord($word, Word::WORD_SERBIAN);
    }

    public function findWord($word, $type) {
        /** @var $word Word */
        $wordEntity = $this->em->getRepository('DictionaryApiBundle:Word')->findOneBy(array(
            'name' => $word,
            'type' => $type
        ));

        if (!$wordEntity) {
            /** @var  $english Word */
            $wordEntity = new Word();
            $wordEntity->setName($word);
            $wordEntity->settype($type);
            $this->em->persist($wordEntity);
            $this->em->flush();
        }

        return $wordEntity;
    }

}