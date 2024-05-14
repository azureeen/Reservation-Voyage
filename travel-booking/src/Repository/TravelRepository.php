<?php

// src/Repository/TravelRepository.php
namespace App\Repository;

use App\Entity\Travel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Travel>
 */
class TravelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Travel::class);
    }

    /**
     * @return Travel[] Returns an array of Travel objects
     */
    public function findAllTravels()
    {
        return $this->findBy([], ['startDate' => 'ASC']);
    }

    /**
     * @return Travel|null Finds a single Travel by the given destination
     */
    public function findOneByDestination(string $destination): ?Travel
    {
        return $this->findOneBy(['destination' => $destination]);
    }

    /**
     * Example of a custom query using QueryBuilder
     *
     * @param string $destination
     * @return Travel[]
     */
    public function findTravelsByDestination(string $destination): array
    {
        $qb = $this->createQueryBuilder('t');
        $qb->where('t.destination = :destination')
            ->setParameter('destination', $destination)
            ->orderBy('t.startDate', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
