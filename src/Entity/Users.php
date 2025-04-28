<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = 1;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
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

    #[ORM\OneToMany(targetEntity: HistoriquePoints::class, mappedBy: 'user_id')]
    private Collection $historiquePoints;

    #[ORM\OneToMany(targetEntity: Roulette::class, mappedBy: 'user_id')]
    private Collection $rouletteSpins;

    public function __construct()
    {
        $this->conversions = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->jobs = new ArrayCollection();
        $this->historiquePoints = new ArrayCollection();
        $this->rouletteSpins = new ArrayCollection();
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

    public function addPoints(int $points): static
    {
        $this->points = ($this->points ?? 0) + $points;
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
            if ($job->getUserId() === $this) {
                $job->setUserId(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, HistoriquePoints>
     */
    public function getHistoriquePoints(): Collection
    {
        return $this->historiquePoints;
    }

    /**
     * @return Collection<int, Roulette>
     */
    public function getRouletteSpins(): Collection
    {
        return $this->rouletteSpins;
    }
}