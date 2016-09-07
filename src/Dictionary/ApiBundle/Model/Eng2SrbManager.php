<?php

namespace Dictionary\ApiBundle\Model;


use Dictionary\ApiBundle\Entity\Eng2srb;
use Dictionary\ApiBundle\Entity\Eng2srbRepository;
use Doctrine\ORM\EntityManager;

class Eng2SrbManager
{
    /**
     * @var $em EntityManager
     */
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function findTranslation($english, $serbian, $direction) {
        /** @var $eng2srbRepository Eng2srbRepository */
        $eng2srbRepository = $this->em->getRepository('DictionaryApiBundle:Eng2srb');
        $eng2SrbItem = $eng2srbRepository->getTranslation($english, $serbian, $direction);
        return $eng2SrbItem;
    }

    public function removeTranslation($english, $serbian, $direction) {
        $eng2SrbItem = $this->findTranslation($english, $serbian, $direction);
        if($eng2SrbItem) {
            $this->em->remove($eng2SrbItem);
            $this->em->flush();
        }
        return true;
    }

    public function findAndCreateTranslation($english, $serbian, $direction, $relevance, $type) {
        $eng2SrbItem = $this->findTranslation($english, $serbian, $direction);

        if (empty($eng2SrbItem)) {
            /** @var  $eng2SrbItem Eng2srb */
            $eng2SrbItem = new Eng2srb();
            $eng2SrbItem->setEng($english);
            $eng2SrbItem->setSrb($serbian);
        }

        $eng2SrbItem->setRelevance($relevance + 1);
        $eng2SrbItem->setDirection($direction);
        $eng2SrbItem->setWordType($type);

        $this->em->persist($eng2SrbItem);
        $this->em->flush();

        return $eng2SrbItem;
    }
}