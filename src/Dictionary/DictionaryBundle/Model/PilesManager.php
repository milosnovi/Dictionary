<?php

namespace Dictionary\DictionaryBundle\Model;


use Dictionary\DictionaryBundle\Entity\Word;

class PilesManager
{
    /**
     * @var $em EntityManager
     */
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

}