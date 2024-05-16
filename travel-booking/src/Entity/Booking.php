<?php

// src/Entity/Booking.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;

/**
 * Represents a booking entity in the application.
 */
#[ORM\Entity(repositoryClass: "App\Repository\BookingRepository")]
class Booking
{
    /**
     * @var int|null The unique identifier of the booking.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    /**
     * @var User The user who made the booking.
     */
    #[ORM\ManyToOne(targetEntity: "App\Entity\User")]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    /**
     * @var Travel The travel associated with the booking.
     */
    #[ORM\ManyToOne(targetEntity: "App\Entity\Travel")]
    #[ORM\JoinColumn(nullable: false)]
    private $travel;

    /**
     * @var \DateTimeInterface The date when the booking was made.
     */
    #[ORM\Column(type: "datetime")]
    #[Assert\NotBlank(message: "Booking date cannot be empty.")]
    #[Assert\Type("\DateTimeInterface", message: "Invalid date format.")]
    #[Assert\FutureOrPresent(message: "The booking date must be in the future or today.")]
    private $bookingDate;

    /**
     * @var string The status of the booking.
     */
    #[ORM\Column(type: "string", length: 255)]
    #[Assert\Choice(choices: ["pending", "confirmed", "cancelled"], message: "Choose a valid status.")]
    private $status;

    /**
     * Get the booking ID.
     *
     * @return int|null The unique identifier of the booking.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the user associated with the booking.
     *
     * @return User|null The user who made the booking.
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set the user associated with the booking.
     *
     * @param User $user The user to associate with the booking.
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get the travel associated with the booking.
     *
     * @return Travel|null The travel associated with the booking.
     */
    public function getTravel(): ?Travel
    {
        return $this->travel;
    }

    /**
     * Set the travel associated with the booking.
     *
     * @param Travel $travel The travel to associate with the booking.
     * @return self
     */
    public function setTravel(Travel $travel): self
    {
        $this->travel = $travel;
        return $this;
    }

    /**
     * Get the booking date.
     *
     * @return \DateTimeInterface|null The date when the booking was made.
     */
    public function getBookingDate(): ?\DateTimeInterface
    {
        return $this->bookingDate;
    }

    /**
     * Set the booking date.
     *
     * @param \DateTimeInterface $bookingDate The date to set for the booking.
     * @return self
     */
    public function setBookingDate(\DateTimeInterface $bookingDate): self
    {
        $this->bookingDate = $bookingDate;
        return $this;
    }

    /**
     * Get the booking status.
     *
     * @return string|null The status of the booking.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Set the booking status.
     *
     * @param string $status The status to set for the booking.
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
}
