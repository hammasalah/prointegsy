<?php

namespace App\Entity;

use App\Repository\ChatParticipantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "chat_participant")]
#[ORM\Entity(repositoryClass: ChatParticipantRepository::class)]
class ChatParticipant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;
    #[ORM\ManyToOne(targetEntity: Conversation::class, inversedBy: "participants")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Conversation $conversation = null;
    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: "participants")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;
        return $this;
    }
    public function getConversation(): ?Conversation
    {
        return $this->conversation;
    }

    public function setConversation(?Conversation $conversation): static
    {
        $this->conversation = $conversation;
        return $this;
    }
}
