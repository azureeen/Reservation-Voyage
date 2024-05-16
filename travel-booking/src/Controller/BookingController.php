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

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        Security $security,
        LoggerInterface $logger
    ) {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->logger = $logger;
    }

    #[Route('/', name: 'home')]
    public function index(Request $request, TravelRepository $travelRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        $booking = new Booking();
        $user = $this->getAuthenticatedUser();
        $booking->setUser($user);

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($booking);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $this->logger->error('Error persisting booking: ' . $e->getMessage());
                $this->addFlash('error', 'An error occurred while processing your booking. Please try again later.');
                return $this->redirectToRoute('home');
            }

            return $this->redirectToRoute('home');
        }

        $lowPriceDeals = $travelRepository->findLowPriceDeals();
        $mostPopularDestinations = $travelRepository->findMostPopularDestinations();
        $allTravels = $travelRepository->findAllTravels();

        return $this->render('booking/index.html.twig', [
            'low_price_deals' => $lowPriceDeals,
            'most_popular_destinations' => $mostPopularDestinations,
            'all_travels' => $allTravels,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/travel/{id}', name: 'view_travel', methods: ['GET', 'POST'])]
    public function viewTravel(Request $request, TravelRepository $travelRepository, int $id): Response
    {
        $travel = $travelRepository->findTravelById($id);
        if (!$travel) {
            throw $this->createNotFoundException('The travel does not exist');
        }

        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        // Check if the user has already booked this travel
        $existingBooking = $this->entityManager->getRepository(Booking::class)->findOneBy([
            'user' => $user,
            'travel' => $travel,
        ]);

        if ($existingBooking) {
            $this->addFlash('error', 'You have already booked this travel.');
            return $this->render('booking/view.html.twig', [
                'travel' => $travel,
                'form' => $this->createForm(BookingType::class)->createView(),
            ]);
        }

        $booking = new Booking();
        $booking->setUser($user);
        $booking->setTravel($travel);
        $booking->setBookingDate(new \DateTime()); // Set the booking date to now
        $booking->setStatus('pending'); // Set the initial status

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($booking);
            $this->entityManager->flush();
            $this->addFlash('success', 'Travel booked successfully!');
            return $this->redirectToRoute('home');
        }

        return $this->render('booking/view.html.twig', [
            'travel' => $travel,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/my-travels', name: 'my_travels')]
    public function myTravels(): Response
    {
        $user = $this->getUser();  // Ensure you have a method to get the authenticated user

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $bookings = $this->entityManager->getRepository(Booking::class)->findBy(['user' => $user]);

        return $this->render('booking/my_travels.html.twig', [
            'bookings' => $bookings
        ]);
    }

    private function getAuthenticatedUser()
    {
        $user = $this->security->getUser();
        if ($user instanceof User) {
            return $user;
        }
        return null;
    }
}
