<?php

// src/Repository/BookingRepository.php
namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository class for the Booking entity.
 *
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository
{
    /**
     * BookingRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    /**
     * Find bookings by user ID.
     *
     * @param int $userId The ID of the user
     * @return Booking[] Returns an array of Booking objects
     */
    public function findByUser(int $userId): array
    {
        return $this->findBy(['user' => $userId], ['bookingDate' => 'DESC']);
    }

    /**
     * Find all bookings sorted by booking date.
     *
     * @return Booking[] Returns an array of Booking objects sorted by date
     */
    public function findAllSortedByDate(): array
    {
        return $this->findBy([], ['bookingDate' => 'ASC']);
    }

    /**
     * Find bookings by a specific date using QueryBuilder.
     *
     * @param \DateTime $date The date to search for bookings
     * @return Booking[] Returns an array of Booking objects
     */
    public function findBookingsByDate(\DateTime $date): array
    {
        $qb = $this->createQueryBuilder('b');
        $qb->where('b.bookingDate = :date')
            ->setParameter('date', $date->format('Y-m-d'));

        return $qb->getQuery()->getResult();
    }
}
