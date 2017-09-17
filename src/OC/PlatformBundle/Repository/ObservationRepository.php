<?php

namespace OC\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ObservationRepository extends EntityRepository
{
    public function getObservsValidated($id)
    {
        return $this->createQueryBuilder('o')
            ->where('o.taxref = :id')
            ->setParameter('id', $id)
            ->andWhere('o.validated = true')
            ->orderBy('o.date', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getObservsToValid($id)
    {
        return $this->createQueryBuilder('o')
            ->where('o.taxref = :id')
            ->setParameter('id', $id)
            ->andWhere('o.validated = false')
            ->orderBy('o.date', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
