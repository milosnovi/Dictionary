<?php

namespace Dictionary\DictionaryBundle\Model;


use Dictionary\DictionaryBundle\Entity\Word;

class WordManager
{
    /**
     * @var $em EntityManager
     */
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function findEnglishWord($word) {
        return $this->findWord($word, Word::WORD_ENGLISH);
    }

    public function findSerbianWord($word, $type) {
        return $this->findWord($word, Word::WORD_SERBIAN, $type);
    }

    public function findWord($word, $type, $wordType = NULL) {
        /** @var $word Word */
        $wordEntity = $this->em->getRepository('DictionaryBundle:Word')->findOneBy(array(
            'name' => $word,
            'type' => $type
        ));

        if (!$wordEntity) {
            /** @var  $english Word */
            $wordEntity = new Word();
            $wordEntity->setName($word);
            $wordEntity->settype($type);
        }

        if($wordType) {
            $wordEntity->setWordType($wordType);
        }

        $this->em->persist($wordEntity);
        $this->em->flush();

        return $wordEntity;
    }

}