<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\UniqueConstraint(name: 'username', columns: ['username'])]
#[ORM\UniqueConstraint(name: 'email', columns: ['email'])]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    private string $username; // Changé ?string en string (NOT NULL)

    #[ORM\Column(type: 'string', length: 255)]
    private string $password; // Changé ?string en string (NOT NULL)

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $email; // Changé ?string en string (NOT NULL)

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $createdAt = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $updatedAt = null;

    #[ORM\Column(type: 'integer', nullable: true, options: ['default' => 0])]
    private ?int $points = 0;

    #[ORM\Column(type: 'integer')]
    private int $age;

    #[ORM\Column(type: 'string', length: 255)]
    private string $gender;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $argent = null;

    // Ajout des relations OneToMany
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Roulette::class)]
    private Collection $roulettes;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: HistoriquePoints::class)]
    private Collection $historiquePoints;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Conversion::class)]
    private Collection $conversions;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: VisiteUtilisateur::class)]
    private Collection $visites;

    // Initialisation des collections
    public function __construct()
    {
        $this->roulettes = new ArrayCollection();
        $this->historiquePoints = new ArrayCollection();
        $this->conversions = new ArrayCollection();
        $this->visites = new ArrayCollection();
    }

    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string // Changé ?string en string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): string // Changé ?string en string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getEmail(): string // Changé ?string en string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;
        return $this;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;
        return $this;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getArgent(): ?string
    {
        return $this->argent;
    }

    public function setArgent(?string $argent): self
    {
        $this->argent = $argent;
        return $this;
    }

    // Ajout des Getters et Setters pour les relations
    public function getRoulettes(): Collection
    {
        return $this->roulettes;
    }

    public function addRoulette(Roulette $roulette): self
    {
        if (!$this->roulettes->contains($roulette)) {
            $this->roulettes[] = $roulette;
            $roulette->setUser($this);
        }
        return $this;
    }

    public function removeRoulette(Roulette $roulette): self
    {
        if ($this->roulettes->removeElement($roulette)) {
            if ($roulette->getUser() === $this) {
                $roulette->setUser(null);
            }
        }
        return $this;
    }

    public function getHistoriquePoints(): Collection
    {
        return $this->historiquePoints;
    }

    public function addHistoriquePoint(HistoriquePoints $historiquePoint): self
    {
        if (!$this->historiquePoints->contains($historiquePoint)) {
            $this->historiquePoints[] = $historiquePoint;
            $historiquePoint->setUser($this);
        }
        return $this;
    }

    public function removeHistoriquePoint(HistoriquePoints $historiquePoint): self
    {
        if ($this->historiquePoints->removeElement($historiquePoint)) {
            if ($historiquePoint->getUser() === $this) {
                $historiquePoint->setUser(null);
            }
        }
        return $this;
    }

    public function getConversions(): Collection
    {
        return $this->conversions;
    }

    public function addConversion(Conversion $conversion): self
    {
        if (!$this->conversions->contains($conversion)) {
            $this->conversions[] = $conversion;
            $conversion->setUser($this);
        }
        return $this;
    }

    public function removeConversion(Conversion $conversion): self
    {
        if ($this->conversions->removeElement($conversion)) {
            if ($conversion->getUser() === $this) {
                $conversion->setUser(null);
            }
        }
        return $this;
    }

    public function getVisites(): Collection
    {
        return $this->visites;
    }

    public function addVisite(VisiteUtilisateur $visite): self
    {
        if (!$this->visites->contains($visite)) {
            $this->visites[] = $visite;
            $visite->setUser($this);
        }
        return $this;
    }

    public function removeVisite(VisiteUtilisateur $visite): self
    {
        if ($this->visites->removeElement($visite)) {
            if ($visite->getUser() === $this) {
                $visite->setUser(null);
            }
        }
        return $this;
    }
}