<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\User;
use App\Form\BookingType;
use App\Repository\UserRepository;
use App\Repository\TravelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Psr\Log\LoggerInterface;

class BookingController extends AbstractController
{
    private $userRepository;
    private $entityManager;
    private $security;
    private $logger;

    // Inject UserRepository, EntityManagerInterface, Security, and LoggerInterface via the constructor
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, Security $security, LoggerInterface $logger)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->logger = $logger;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, TravelRepository $travelRepository): Response
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
            try {
                $this->entityManager->persist($booking);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                // Log detailed error for developers/administrators
                $this->logger->error('Error persisting booking: ' . $e->getMessage());

                // Display a generic error message to the user
                $this->addFlash('error', 'An error occurred while processing your booking. Please try again later.');
                return $this->redirectToRoute('home');
            }

            return $this->redirectToRoute('home');
        }

        // Fetch low price deals
        $lowPriceDeals = $travelRepository->findLowPriceDeals();

        // Fetch most popular destinations
        $mostPopularDestinations = $travelRepository->findMostPopularDestinations();

        // Fetch all destinations
        $allTravels = $travelRepository->findAllTravels();

        return $this->render('booking/index.html.twig', [
            'low_price_deals' => $lowPriceDeals,
            'most_popular_destinations' => $mostPopularDestinations,
            'all_travels' => $allTravels,
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
        if ($user instanceof User) {
            return $user;
        }

        return null;
    }
}
