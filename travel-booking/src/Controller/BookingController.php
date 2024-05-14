<?php

// src/Controller/BookingController.php
namespace App\Controller;

use App\Entity\Booking;
use App\Entity\User;
use App\Form\BookingType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    private $userRepository;
    private $entityManager;

    // Inject both UserRepository and EntityManagerInterface via the constructor
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
        // Check if user is authenticated
        if (!$this->getUser()) {
            // Redirect unauthenticated users to the login page
            return $this->redirectToRoute('login');
        }

        $booking = new Booking();

        // Call the randomUser method
        $user = $this->randomUser();
        $booking->setUser($user);

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle form errors
            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                // Log or display the errors as needed
            }
            $this->entityManager->persist($booking);
            $this->entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('booking/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Adjust randomUser method to use the entityManager property
    public function randomUser()
    {
        $conn = $this->entityManager->getConnection();
        $sql = 'SELECT * FROM users ORDER BY RAND() LIMIT 1';
        $stmt = $conn->executeQuery($sql);
        $userData = $stmt->fetchAssociative();

        if (!$userData) {
            return null;
        }

        return $this->entityManager->getRepository(User::class)->find($userData['id']);
    }
}
