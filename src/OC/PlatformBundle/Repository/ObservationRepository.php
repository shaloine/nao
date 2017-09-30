<?php

namespace OC\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ObservationRepository extends EntityRepository
{
    // Get back and returns the list of observations validated
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

    // Get back and returns the list of observations awaiting validation
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

    // Get back and returns the GPS coordinates for an observation
    public function getLocations($id)
    {
        return $this->createQueryBuilder('o')
            ->select('o.latitude')
            ->addSelect('o.longitude')
            ->where('o.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ;
    }
}
