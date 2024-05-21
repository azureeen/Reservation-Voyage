<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Travel;
use App\Entity\User;
use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class BookingControllerTest extends WebTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::$container->get(EntityManagerInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseRedirects('/login');

        // Simulate login
        $user = $this->createTestUser();
        $client->request('GET', '/login');
        $client->submitForm('Login', [
            '_username' => 'testuser@example.com',
            '_password' => 'password12345',
        ]);
        $client->followRedirect();

        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name="booking"]');
    }

    public function testBookTravel()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $client->submitForm('Login', [
            '_username' => 'testuser@example.com',
            '_password' => 'password12345',
        ]);
        $client->followRedirect();

        $travel = $this->createTestTravel();
        $crawler = $client->request('GET', '/travel/' . $travel->getId());

        $form = $crawler->selectButton('Book Travel')->form();
        $client->submit($form);

        $this->assertResponseRedirects('/');

        $booking = $this->entityManager->getRepository(Booking::class)->findOneBy(['user' => $this->getUser(), 'travel' => $travel]);
        $this->assertNotNull($booking);
    }

    public function testPreventDuplicateBooking()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $client->submitForm('Login', [
            '_username' => 'testuser@example.com',
            '_password' => 'password12345',
        ]);
        $client->followRedirect();

        $travel = $this->createTestTravel();

        // Book the travel for the first time
        $client->request('GET', '/travel/' . $travel->getId());
        $form = $client->getCrawler()->selectButton('Book Travel')->form();
        $client->submit($form);

        // Attempt to book the same travel again
        $client->request('GET', '/travel/' . $travel->getId());
        $form = $client->getCrawler()->selectButton('Book Travel')->form();
        $client->submit($form);

        $this->assertSelectorTextContains('.flash-error', 'You have already booked this travel.');
    }

    public function testMyTravels()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $client->submitForm('Login', [
            '_username' => 'testuser@example.com',
            '_password' => 'password12345',
        ]);
        $client->followRedirect();

        $client->request('GET', '/my-travels');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.booking-list');
    }

    private function createTestUser()
    {
        $user = new User();
        $user->setEmail('testuser@example.com');
        $user->setFirstName('Test');
        $user->setLastName('User');
        $passwordHasher = self::$container->get(UserPasswordHasherInterface::class);
        $user->setPassword($passwordHasher->hashPassword($user, 'password12345'));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    private function createTestTravel()
    {
        $travel = new Travel();
        $travel->setDestination('Test Destination');
        $travel->setDepartureLocation('Test Departure');
        $travel->setStartDate(new \DateTime('+1 day'));
        $travel->setEndDate(new \DateTime('+5 days'));
        $travel->setDescription('Test Description');
        $travel->setPrice('100.00');
        $travel->setImagePath(null);
        $this->entityManager->persist($travel);
        $this->entityManager->flush();

        return $travel;
    }
}
