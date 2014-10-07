<?php

namespace Dictionary\DictionaryBundle\Model;


use Dictionary\DictionaryBundle\Entity\History;
use Dictionary\DictionaryBundle\Entity\Word;

class HistoryManager
{
    /**
     * @var $em EntityManager
     */
    private $em;

    public function __construct($em) {
        $this->em = $em;

    }

    public function updateHistoryLog($user, $word) {
        $wordEntity = $this->em->getRepository('DictionaryBundle:Word')->findOneBy(
            array(
                'name' => $word,
                'type' => Word::WORD_ENGLISH
            )
        );;

        $historyRepository = $this->em->getRepository('DictionaryBundle:History');
        /** @var  $historyLog History */
        $historyLog = $historyRepository->findOneBy(
            array(
                'word' => $wordEntity,
                'user' => $user
            )
        );

        if ($historyLog) {
            $hits = (int)$historyLog->getHits() + 1;
            $historyLog->setHits($hits);
        } else {
            /** @var $history History */
            $historyLog = new History();
            $historyLog->setWord($wordEntity);
            $historyLog->setUser($user);
            $historyLog->setHits(1);
        }
        $this->em->persist($historyLog);
        $this->em->flush();
    }
}