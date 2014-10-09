<?php

namespace Dictionary\DictionaryBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PilesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PilesRepository extends EntityRepository
{

    public function findPiles($user)
    {
        $piles = $this->createQueryBuilder('piles')
            ->select('piles, word')
            ->innerJoin('piles.word', 'word')
            ->where('piles.user = :user')
            ->setParameter('user', $user)
            ->orderBy('piles.type, piles.updated', 'DESC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;

        return $piles;
    }
}
