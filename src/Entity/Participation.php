<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipationRepository::class)]
class Participation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Events::class)]
    private Collection $event_id;

    #[ORM\ManyToMany(targetEntity: Users::class)]
    private Collection $participant_id;

    public function __construct()
    {
        $this->event_id = new ArrayCollection();
        $this->participant_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Events>
     */
    public function getEventId(): Collection
    {
        return $this->event_id;
    }

    public function addEventId(Events $eventId): static
    {
        if (!$this->event_id->contains($eventId)) {
            $this->event_id->add($eventId);
        }

        return $this;
    }

    public function removeEventId(Events $eventId): static
    {
        $this->event_id->removeElement($eventId);

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getParticipantId(): Collection
    {
        return $this->participant_id;
    }

    public function addParticipantId(Users $participantId): static
    {
        if (!$this->participant_id->contains($participantId)) {
            $this->participant_id->add($participantId);
        }

        return $this;
    }

    public function removeParticipantId(Users $participantId): static
    {
        $this->participant_id->removeElement($participantId);

        return $this;
    }
}
