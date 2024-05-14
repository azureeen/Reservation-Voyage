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
use Symfony\Component\Security\Core\Security;

class BookingController extends AbstractController
{
    private $userRepository;
    private $entityManager;
    private $security;

    // Inject both UserRepository, EntityManagerInterface, and Security via the constructor
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->security = $security;
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

        // Call the getAuthenticatedUser method
        $user = $this->getAuthenticatedUser();
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

    /**
     * Get the authenticated user.
     *
     * @return User|null The authenticated user or null if not authenticated
     */
    public function getAuthenticatedUser()
    {
        // Get the current user
        $user = $this->security->getUser();

        // Check if a user is authenticated
        if ($user) {
            return $user->getUserIdentifier();
        }
    }
}
