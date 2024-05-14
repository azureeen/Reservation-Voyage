<?php

// src/DataFixtures/TravelFixtures.php
namespace App\DataFixtures;

use App\Entity\Travel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class TravelFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $travel1 = new Travel();
        $travel1->setDestination("Paris");
        $travel1->setDepartureLocation("New York");
        $travel1->setStartDate(new DateTime("2024-05-20"));
        $travel1->setEndDate(new DateTime("2024-05-30"));
        $travel1->setDescription("Enjoy a romantic getaway to the City of Lights.");
        $travel1->setPrice(1200.00);

        $manager->persist($travel1);

        $travel2 = new Travel();
        $travel2->setDestination("Tokyo");
        $travel2->setDepartureLocation("San Francisco");
        $travel2->setStartDate(new DateTime("2024-06-15"));
        $travel2->setEndDate(new DateTime("2024-06-25"));
        $travel2->setDescription("Experience the bustling streets and vibrant culture of Tokyo.");
        $travel2->setPrice(1500.00);

        $manager->persist($travel2);

        // You can add more travels here...

        $manager->flush();
    }
}
