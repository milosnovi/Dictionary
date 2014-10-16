<?php

namespace Dictionary\DictionaryBundle\Model;


use Dictionary\DictionaryBundle\Entity\Eng2srb;
use Dictionary\DictionaryBundle\Entity\Eng2srbRepository;

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

    public function findTranslation($english, $serbian, $direction, $relevance, $type) {
        /** @var $eng2srbRepository Eng2srbRepository */
        $eng2srbRepository = $this->em->getRepository('DictionaryBundle:Eng2srb');
        $eng2SrbItem = $eng2srbRepository->getTranslation($english, $serbian, $direction);

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