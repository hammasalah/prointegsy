<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="visite_utilisateur")
 */
class VisiteUtilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dernier_visite;

    /**
     * @ORM\Column(type="integer")
     */
    private $serie;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="visites") // Change "Users" en "User"
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDernierVisite(): \DateTimeInterface
    {
        return $this->dernier_visite;
    }

    public function setDernierVisite(\DateTimeInterface $dernier_visite): self
    {
        $this->dernier_visite = $dernier_visite;
        return $this;
    }

    public function getSerie(): int
    {
        return $this->serie;
    }

    public function setSerie(int $serie): self
    {
        $this->serie = $serie;
        return $this;
    }

    public function getUserId(): int // Change ?int en int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self // Change ?int en int
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getUser(): ?Users // Change "Users" en "User"
    {
        return $this->user;
    }

    public function setUser(?Users $user): self // Change "Users" en "User"
    {
        $this->user = $user;
        $this->user_id = $user ? $user->getId() : null; // Corrige l'incohérence ici
        return $this;
    }
}