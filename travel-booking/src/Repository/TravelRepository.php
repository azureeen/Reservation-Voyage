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

    public function findLowPriceDeals($limit = 5)
    {
        // Implement logic to find low price deals
        // For example:
        return $this->createQueryBuilder('t')
            ->orderBy('t.price', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findMostPopularDestinations($limit = 5)
    {
        // Implement logic to find most popular destinations
        return $this->createQueryBuilder('t')
            ->select('t.destination', 't.departureLocation', 't.startDate', 't.endDate', 't.description', 't.price', 't.imagePath',
                '(SELECT COUNT(b.id) FROM App\Entity\Booking b WHERE b.travel = t.id) AS bookingCount')
            ->orderBy('bookingCount', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

}
