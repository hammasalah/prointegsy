<?php

namespace App\Entity;

use App\Repository\RouletteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RouletteRepository::class)]
#[ORM\Table(name: "Roulette")]
class Roulette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Users $user_id = null;

    #[ORM\Column]
    private ?int $points_gagnes = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?Users
    {
        return $this->user_id;
    }

    public function setUserId(?Users $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getPointsGagnes(): ?int
    {
        return $this->points_gagnes;
    }

    public function setPointsGagnes(int $points_gagnes): static
    {
        $this->points_gagnes = $points_gagnes;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}
