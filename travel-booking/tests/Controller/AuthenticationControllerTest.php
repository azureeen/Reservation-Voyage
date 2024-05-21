<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthenticationControllerTest extends WebTestCase
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

    public function testRegister()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Register')->form([
            'registration_form[email]' => 'testuser@example.com',
            'registration_form[plainPassword][first]' => 'password12345',
            'registration_form[plainPassword][second]' => 'password12345',
            'registration_form[firstName]' => 'Test',
            'registration_form[lastName]' => 'User',
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/login');

        $user = $this->entityManager->getRepository(User::class)->findOneByEmail('testuser@example.com');
        $this->assertNotNull($user);
    }

    public function testLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();

        // Create a user for login
        $user = new User();
        $user->setEmail('testuser@example.com');
        $user->setFirstName('Test');
        $user->setLastName('User');
        $passwordHasher = self::$container->get(UserPasswordHasherInterface::class);
        $user->setPassword($passwordHasher->hashPassword($user, 'password12345'));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $form = $crawler->selectButton('Login')->form([
            '_username' => 'testuser@example.com',
            '_password' => 'password12345',
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/');
    }

    public function testLogout()
    {
        $client = static::createClient();
        $client->request('GET', '/logout');

        $this->assertResponseRedirects('/');
    }
}
