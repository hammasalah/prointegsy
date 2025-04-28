<?php

namespace App\Entity;

use App\Repository\VisiteUtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisiteUtilisateurRepository::class)]
#[ORM\Table(name: "VisiteUtilisateur")]
class VisiteUtilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dernier_visite = null;

    #[ORM\Column]
    private ?int $serie = null;

    #[ORM\Column]
    private ?int $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDernierVisite(): ?\DateTimeInterface
    {
        return $this->dernier_visite;
    }

    public function setDernierVisite(\DateTimeInterface $dernier_visite): static
    {
        $this->dernier_visite = $dernier_visite;

        return $this;
    }

    public function getSerie(): ?int
    {
        return $this->serie;
    }

    public function setSerie(int $serie): static
    {
        $this->serie = $serie;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }
}
