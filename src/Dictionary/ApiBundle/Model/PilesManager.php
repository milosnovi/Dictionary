<?php

namespace Dictionary\ApiBundle\Model;

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