<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\Table(name: 'users')]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: VisiteUtilisateur::class, mappedBy: 'user')]
    private Collection $visites;


    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255 , nullable: true)]
    private ?string $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $points = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $argent = null;

    #[ORM\OneToMany(targetEntity: Conversion::class, mappedBy: 'userId')]
    private Collection $conversions;

    #[ORM\OneToMany(targetEntity: Events::class, mappedBy: 'organizerId')]
    private Collection $events;

    #[ORM\OneToMany(targetEntity: Jobs::class, mappedBy: 'userId', orphanRemoval: true)]
    private Collection $jobs;

    #[ORM\OneToMany(targetEntity: Roulette::class, mappedBy: 'user')]
    private Collection $roulettes;

    #[ORM\OneToMany(targetEntity: HistoriquePoints::class, mappedBy: 'user')]
    private Collection $historiquePoints;

    public function __construct()
    {
        $this->conversions = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->jobs = new ArrayCollection();
        $this->roulettes = new ArrayCollection();
        $this->historiquePoints = new ArrayCollection();
    }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getArgent(): ?string
    {
        return $this->argent;
    }

    public function setArgent(?string $argent): static
    {
        $this->argent = $argent;
        return $this;
    }

    /**
     * @return Collection<int, Conversion>
     */
    public function getConversions(): Collection
    {
        return $this->conversions;
    }

    public function addConversion(Conversion $conversion): static
    {
        if (!$this->conversions->contains($conversion)) {
            $this->conversions->add($conversion);
            $conversion->setUserId($this);
        }

        return $this;
    }

    public function removeConversion(Conversion $conversion): static
    {
        if ($this->conversions->removeElement($conversion)) {
            // set the owning side to null (unless already changed)
            if ($conversion->getUserId() === $this) {
                $conversion->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Events>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setOrganizerId($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getOrganizerId() === $this) {
                $event->setOrganizerId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Jobs>
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Jobs $job): static
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs->add($job);
            $job->setUserId($this);
        }

        return $this;
    }

    public function removeJob(Jobs $job): static
    {
        if ($this->jobs->removeElement($job)) {
            // set the owning side to null (unless already changed)
            if ($job->getUserId() === $this) {
                $job->setUserId(null);
            }
        }

        return $this;
    }


// Ajout : Méthodes pour gérer la relation avec Roulette.
    /**
     * @return Collection<int, Roulette>
     */
    public function getRoulettes(): Collection
    {
        return $this->roulettes;
    }

    public function addRoulette(Roulette $roulette): static
    {
        if (!$this->roulettes->contains($roulette)) {
            $this->roulettes->add($roulette);
            $roulette->setUser($this);
        }
        return $this;
    }

    public function removeRoulette(Roulette $roulette): static
    {
        if ($this->roulettes->removeElement($roulette)) {
            if ($roulette->getUser() === $this) {
                $roulette->setUser(null);
            }
        }
        return $this;
    }

    // Ajout : Méthodes pour gérer la relation avec HistoriquePoints.
    /**
     * @return Collection<int, HistoriquePoints>
     */
    public function getHistoriquePoints(): Collection
    {
        return $this->historiquePoints;
    }

    public function addHistoriquePoint(HistoriquePoints $historiquePoint): static
    {
        if (!$this->historiquePoints->contains($historiquePoint)) {
            $this->historiquePoints->add($historiquePoint);
            $historiquePoint->setUser($this);
        }
        return $this;
    }

    public function removeHistoriquePoint(HistoriquePoints $historiquePoint): static
    {
        if ($this->historiquePoints->removeElement($historiquePoint)) {
            if ($historiquePoint->getUser() === $this) {
                $historiquePoint->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, VisiteUtilisateur>
     */
    public function getVisites(): Collection
    {
        return $this->visites;
    }

    public function addVisite(VisiteUtilisateur $visite): static
    {
        if (!$this->visites->contains($visite)) {
            $this->visites->add($visite);
            $visite->setUser($this);
        }
        return $this;
    }

    public function removeVisite(VisiteUtilisateur $visite): static
    {
        if ($this->visites->removeElement($visite)) {
            if ($visite->getUser() === $this) {
                $visite->setUser(null);
            }
        }
        return $this;
    }

}
