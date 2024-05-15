<?php
// src/DataFixtures/BookingFixtures.php
namespace App\DataFixtures;

use App\Entity\Booking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use DateTime;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $statuses = ['pending', 'confirmed', 'cancelled'];

        // Create 30 bookings
        for ($i = 0; $i < 30; $i++) {
            $booking = new Booking();

            // Get random user and travel references
            $userReference = $this->getReference('user_' . rand(0, 9));
            $travelReference = $this->getReference('travel_' . rand(0, 12)); // Adjust if you have more or fewer travels

            // Set properties for the booking
            $booking->setUser($userReference);
            $booking->setTravel($travelReference);
            $booking->setBookingDate(new DateTime('now + ' . rand(1, 30) . ' days'));
            $booking->setStatus($statuses[array_rand($statuses)]);

            $manager->persist($booking);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            TravelFixtures::class,
        ];
    }
}
