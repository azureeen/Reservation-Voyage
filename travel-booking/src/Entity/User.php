<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Represents a user entity in the application.
 */
#[ORM\Entity]
#[ORM\Table(name: "users")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @var int|null The unique identifier of the user.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    /**
     * @var string The first name of the user.
     */
    #[ORM\Column(type: "string")]
    private string $firstName;

    /**
     * @var string The last name of the user.
     */
    #[ORM\Column(type: "string")]
    private string $lastName;

    /**
     * @var string The email address of the user.
     */
    #[ORM\Column(type: "string", length: 180, unique: true)]
    private string $email;

    /**
     * @var string The hashed password.
     */
    #[ORM\Column(type: "string")]
    private string $password;

    /**
     * @var array The roles assigned to the user.
     */
    #[ORM\Column(type: "json")]
    private array $roles = [];

    /**
     * Get the user ID.
     *
     * @return int|null The unique identifier of the user.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the email address of the user.
     *
     * @return string The email address of the user.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the email address of the user.
     *
     * @param string $email The email address to set.
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the hashed password of the user.
     *
     * @return string The hashed password of the user.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the hashed password of the user.
     *
     * @param string $password The hashed password to set.
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get the roles of the user.
     *
     * @return array The roles assigned to the user.
     */
    public function getRoles(): array
    {
        // guarantee every user at least has ROLE_USER
        return array_unique(array_merge(['ROLE_USER'], $this->roles));
    }

    /**
     * Set the roles of the user.
     *
     * @param array $roles The roles to set.
     * @return self
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Get the first name of the user.
     *
     * @return string The first name of the user.
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Set the first name of the user.
     *
     * @param string $firstName The first name to set.
     * @return void
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * Get the last name of the user.
     *
     * @return string The last name of the user.
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Set the last name of the user.
     *
     * @param string $lastName The last name to set.
     * @return void
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * Get the username used for authentication.
     *
     * @return string The email address of the user.
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * Get the salt used to encode the password.
     *
     * @return string|null Not needed for modern algorithms.
     */
    public function getSalt(): ?string
    {
        // Not needed for modern algorithms
        return null;
    }

    /**
     * Erase sensitive data from the user.
     *
     * @return void
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    /**
     * Get the identifier used for authentication.
     *
     * @return string The email address of the user.
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
