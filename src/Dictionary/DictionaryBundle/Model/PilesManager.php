<?php

namespace Dictionary\DictionaryBundle\Model;

use Doctrine\ORM\EntityManager;

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