<?php

// src/Entity/Booking.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;


#[ORM\Entity(repositoryClass: "App\Repository\BookingRepository")]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\ManyToOne(targetEntity: "App\Entity\User")]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Travel")]
    #[ORM\JoinColumn(nullable: false)]
    private $travel;

    #[ORM\Column(type: "datetime")]
    #[Assert\NotBlank(message: "Booking date cannot be empty.")]
    #[Assert\Type("\DateTimeInterface", message: "Invalid date format.")]
    #[Assert\FutureOrPresent(message: "The booking date must be in the future or today.")]
    private $bookingDate;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\Choice(choices: ["pending", "confirmed", "cancelled"], message: "Choose a valid status.")]
    private $status;

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getTravel(): ?Travel
    {
        return $this->travel;
    }

    public function setTravel(Travel $travel): self
    {
        $this->travel = $travel;
        return $this;
    }

    public function getBookingDate(): ?\DateTimeInterface
    {
        return $this->bookingDate;
    }

    public function setBookingDate(\DateTimeInterface $bookingDate): self
    {
        $this->bookingDate = $bookingDate;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
}
