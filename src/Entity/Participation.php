<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipationRepository::class)]
#[ORM\Table(name: 'participation')]
class Participation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'event_id', referencedColumnName: 'id')]
    private ?Events $event = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'participant_id', referencedColumnName: 'id')]
    private ?Users $participant = null;

    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?Events
    {
        return $this->event;
    }

    public function setEvent(?Events $event): self
    {
        $this->event = $event;
        return $this;
    }

    public function getParticipant(): ?Users
    {
        return $this->participant;
    }

    public function setParticipant(?Users $participant): self
    {
        $this->participant = $participant;
        return $this;
    }
}