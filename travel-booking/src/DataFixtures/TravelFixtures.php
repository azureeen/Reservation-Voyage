<?php
// src/DataFixtures/TravelFixtures.php
namespace App\DataFixtures;

use App\Entity\Travel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TravelFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $destinations = [
            ["Paris", "2024-05-20", "2024-05-30", "Enjoy a romantic getaway to the City of Lights.", 1200.00, "/images/paris.webp"],
            ["Tokyo", "2024-06-15", "2024-06-25", "Experience the bustling streets and vibrant culture of Tokyo.", 1500.00, "/images/tokyo.webp"],
            ["Maldives", "2024-07-01", "2024-07-11", "Relax in the stunning beaches of Maldives.", 3000.00, "/images/maldives.webp"],
            ["Venice", "2024-08-10", "2024-08-20", "Explore the enchanting canals of Venice.", 1800.00, "/images/venice.webp"],
            ["New York", "2024-09-05", "2024-09-15", "Discover the vibrant life of New York City.", 2000.00, "/images/newyork.webp"],
            ["Cairo", "2024-10-01", "2024-10-11", "Dive into the history of ancient Egypt in Cairo.", 1700.00, "/images/cairo.webp"],
            ["London", "2024-11-20", "2024-11-30", "Visit the historical landmarks of London.", 1500.00, "/images/london.webp"],
            ["Sydney", "2024-12-10", "2024-12-20", "Enjoy the vibrant scenes of Sydney.", 2500.00, "/images/sydney.webp"],
            ["Santorini", "2025-01-15", "2025-01-25", "Experience the stunning views of Santorini.", 2200.00, "/images/santorini.webp"],
            ["Rio de Janeiro", "2025-02-10", "2025-02-20", "Celebrate the lively culture of Rio de Janeiro.", 2600.00, "/images/rio.webp"],
            ["Cape Town", "2025-03-01", "2025-03-11", "Marvel at the beauty of Cape Town.", 2400.00, "/images/capetown.webp"],
            ["Bangkok", "2025-04-15", "2025-04-25", "Immerse in the rich culture of Bangkok.", 1300.00, "/images/bangkok.webp"],
            ["Dubai", "2025-05-10", "2025-05-20", "Experience luxury and innovation in Dubai.", 3400.00, "/images/dubai.webp"]
        ];

        foreach ($destinations as $i => $dest) {
            $travel = new Travel();
            $travel->setDestination($dest[0]);
            $travel->setDepartureLocation("France");
            $travel->setStartDate(new \DateTime($dest[1]));
            $travel->setEndDate(new \DateTime($dest[2]));
            $travel->setDescription($dest[3]);
            $travel->setPrice($dest[4]);
            $travel->setImagePath($dest[5]);

            $manager->persist($travel);
            // Add a reference to use in BookingFixtures
            $this->addReference('travel_' . $i, $travel);
        }

        $manager->flush();
    }
}
