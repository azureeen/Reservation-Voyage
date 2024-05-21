<?php

// src/Entity/Travel.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

// TODO : SQL Injection : Doctrine ORM

/**
 * Represents a travel entity in the application.
 */
#[ORM\Entity(repositoryClass: "App\Repository\TravelRepository")]
class Travel
{
    /**
     * @var int|null The unique identifier of the travel.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    /**
     * @var string The destination of the travel.
     */
    #[ORM\Column(type: "string", length: 255)]
    private $destination;

    /**
     * @var string The departure location of the travel.
     */
    #[ORM\Column(type: "string", length: 255)]
    private $departureLocation;

    /**
     * @var \DateTimeInterface The start date of the travel.
     */
    #[ORM\Column(type: "datetime")]
    private $startDate;

    /**
     * @var \DateTimeInterface The end date of the travel.
     */
    #[ORM\Column(type: "datetime")]
    private $endDate;

    /**
     * @var string The description of the travel.
     */
    #[ORM\Column(type: "text")]
    private $description;

    /**
     * @var string The price of the travel.
     */
    #[ORM\Column(type: "decimal", scale: 2)]
    private $price;

    /**
     * @var string|null The image path for the travel.
     */
    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $imagePath;

    /**
     * Get the travel ID.
     *
     * @return int|null The unique identifier of the travel.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the destination of the travel.
     *
     * @return string|null The destination of the travel.
     */
    public function getDestination(): ?string
    {
        return $this->destination;
    }

    /**
     * Set the destination of the travel.
     *
     * @param string $destination The destination to set.
     * @return self
     */
    public function setDestination(string $destination): self
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * Get the departure location of the travel.
     *
     * @return string|null The departure location of the travel.
     */
    public function getDepartureLocation(): ?string
    {
        return $this->departureLocation;
    }

    /**
     * Set the departure location of the travel.
     *
     * @param string $departureLocation The departure location to set.
     * @return self
     */
    public function setDepartureLocation(string $departureLocation): self
    {
        $this->departureLocation = $departureLocation;
        return $this;
    }

    /**
     * Get the start date of the travel.
     *
     * @return \DateTimeInterface|null The start date of the travel.
     */
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * Set the start date of the travel.
     *
     * @param \DateTimeInterface $startDate The start date to set.
     * @return self
     */
    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * Get the end date of the travel.
     *
     * @return \DateTimeInterface|null The end date of the travel.
     */
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * Set the end date of the travel.
     *
     * @param \DateTimeInterface $endDate The end date to set.
     * @return self
     */
    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * Get the description of the travel.
     *
     * @return string|null The description of the travel.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the description of the travel.
     *
     * @param string $description The description to set.
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get the price of the travel.
     *
     * @return string|null The price of the travel.
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * Set the price of the travel.
     *
     * @param string $price The price to set.
     * @return self
     */
    public function setPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get the image path of the travel.
     *
     * @return string|null The image path of the travel.
     */
    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    /**
     * Set the image path of the travel.
     *
     * @param string|null $imagePath The image path to set.
     * @return self
     */
    public function setImagePath(?string $imagePath): self
    {
        $this->imagePath = $imagePath;
        return $this;
    }
}
