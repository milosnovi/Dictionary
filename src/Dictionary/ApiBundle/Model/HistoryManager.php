<?php

namespace Dictionary\ApiBundle\Model;


use Dictionary\ApiBundle\Entity\History;
use Dictionary\ApiBundle\Entity\Word;
use Doctrine\ORM\EntityManager;

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
        $wordEntity = $this->em->getRepository('DictionaryApiBundle:Word')->findOneBy(
            array(
                'name' => $word,
                'type' => Word::WORD_ENGLISH
            )
        );;

        $historyRepository = $this->em->getRepository('DictionaryApiBundle:History');
        /** @var  $historyLog History */
        $historyLog = $historyRepository->findOneBy([
                'word' => $wordEntity,
                'anonymousId' => $user
            ]
        );
//        \Doctrine\Common\Util\Debug::dump($wordEntity->getId(),2);
//        \Doctrine\Common\Util\Debug::dump($user, 2);
//        \Doctrine\Common\Util\Debug::dump($historyLog,2);exit;
        if ($historyLog) {
            $hits = (int)$historyLog->getHits() + 1;
            $historyLog->setHits($hits);
        } else {
            /** @var $history History */
            $historyLog = new History();
            $historyLog->setWord($wordEntity);
            $historyLog->setAnonymousId($user);
            $historyLog->setHits(1);
        }
//
        $this->em->persist($historyLog);
        $this->em->flush();
    }
}