<?php
// src/DataFixtures/UserFixtures.php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $users = [
            ['user1@example.com', 'ComplexPass!123', 'John', 'Doe'],
            ['user2@example.com', 'StrongPassword#456', 'Jane', 'Doe'],
            ['user3@example.com', 'SecurePass$789', 'Alice', 'Smith'],
            ['user4@example.com', 'Password!234', 'Bob', 'Johnson'],
            ['user5@example.com', 'Pass@word345', 'Charlie', 'Brown'],
            ['user6@example.com', 'Password#456', 'David', 'Williams'],
            ['user7@example.com', 'Secure!Pass789', 'Eve', 'Davis'],
            ['user8@example.com', 'Strong#Pass123', 'Frank', 'Garcia'],
            ['user9@example.com', 'Complex$Pass234', 'Grace', 'Martinez'],
            ['user10@example.com', 'Secure!Password456', 'Hannah', 'Lopez']
        ];

        foreach ($users as $i => $userData) {
            $user = new User();
            $user->setEmail($userData[0]);
            $user->setPassword($this->passwordHasher->hashPassword($user, $userData[1]));
            $user->setFirstName($userData[2]);
            $user->setLastName($userData[3]);

            $manager->persist($user);
            // Add a reference to use in BookingFixtures
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}
