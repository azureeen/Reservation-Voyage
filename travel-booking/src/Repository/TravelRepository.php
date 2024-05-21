<?php

// src/Repository/TravelRepository.php
namespace App\Repository;

use App\Entity\Travel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository class for the Travel entity.
 *
 * @extends ServiceEntityRepository<Travel>
 */
class TravelRepository extends ServiceEntityRepository
{
    /**
     * TravelRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Travel::class);
    }

    /**
     * Find all travels sorted by start date.
     *
     * @return Travel[] Returns an array of Travel objects
     */
    public function findAllTravels(): array
    {
        return $this->findBy([], ['startDate' => 'ASC']);
    }

    /**
     * Find a single travel by the given destination.
     *
     * @param string $destination
     * @return Travel|null Returns a single Travel object or null
     */
    public function findOneByDestination(string $destination): ?Travel
    {
        return $this->findOneBy(['destination' => $destination]);
    }

    /**
     * Find a single travel by the given ID.
     *
     * @param int $id
     * @return Travel|null Returns a single Travel object or null
     */
    public function findTravelById(int $id): ?Travel
    {
        return $this->findOneBy(['id' => $id]);
    }

    /**
     * Find travels by the given destination using QueryBuilder.
     *
     * @param string $destination
     * @return Travel[] Returns an array of Travel objects
     */
    public function findTravelsByDestination(string $destination): array
    {
        $qb = $this->createQueryBuilder('t');
        $qb->where('t.destination = :destination')
            ->setParameter('destination', $destination)
            ->orderBy('t.startDate', 'ASC');

        return $qb->getQuery()->getResult();
    }

    // TODO : SQL Injection : Query Builder

    /**
     * Find travels with the lowest prices.
     *
     * @param int $limit
     * @return Travel[] Returns an array of Travel objects
     */
    public function findLowPriceDeals(int $limit = 5): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.price', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find the most popular travel destinations based on booking count.
     *
     * @param int $limit
     * @return array Returns an array of Travel objects with booking counts
     */
    public function findMostPopularDestinations(int $limit = 5): array
    {
        return $this->createQueryBuilder('t')
            ->select('t.id', 't.destination', 't.departureLocation', 't.startDate', 't.endDate', 't.description', 't.price', 't.imagePath',
                '(SELECT COUNT(b.id) FROM App\Entity\Booking b WHERE b.travel = t.id) AS bookingCount')
            ->orderBy('bookingCount', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
