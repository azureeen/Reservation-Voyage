<?php

// src/Repository/BookingRepository.php
namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    /**
     * @return Booking[] Returns an array of Booking objects
     */
    public function findByUser($userId)
    {
        return $this->findBy(['user' => $userId], ['bookingDate' => 'DESC']);
    }

    /**
     * @return Booking[] Returns an array of Booking objects sorted by date
     */
    public function findAllSortedByDate()
    {
        return $this->findBy([], ['bookingDate' => 'ASC']);
    }

    /**
     * Example of a custom query using QueryBuilder
     *
     * @param \DateTime $date
     * @return Booking[]
     */
    public function findBookingsByDate(\DateTime $date)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->where('b.bookingDate = :date')
            ->setParameter('date', $date->format('Y-m-d'));

        return $qb->getQuery()->getResult();
    }
}
