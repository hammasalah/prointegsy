<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'UserRewards')]
class UserRewards
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $userRewardId = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'user_id', onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Reward::class)]
    #[ORM\JoinColumn(name: 'reward_id', referencedColumnName: 'reward_id', onDelete: 'CASCADE')]
    private ?Reward $reward = null;

    #[ORM\ManyToOne(targetEntity: Event::class)]
    #[ORM\JoinColumn(name: 'event_id', referencedColumnName: 'event_id', onDelete: 'SET NULL')]
    private ?Event $event = null;

    #[ORM\Column(type: 'integer')]
    private int $pointsEarned;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $earnedAt = null;

    // Getters et Setters
    public function getUserRewardId(): ?int
    {
        return $this->userRewardId;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getReward(): ?Reward
    {
        return $this->reward;
    }

    public function setReward(?Reward $reward): self
    {
        $this->reward = $reward;
        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;
        return $this;
    }

    public function getPointsEarned(): int
    {
        return $this->pointsEarned;
    }

    public function setPointsEarned(int $pointsEarned): self
    {
        $this->pointsEarned = $pointsEarned;
        return $this;
    }

    public function getEarnedAt(): ?string
    {
        return $this->earnedAt;
    }

    public function setEarnedAt(?string $earnedAt): self
    {
        $this->earnedAt = $earnedAt;
        return $this;
    }
}

// Compare this snippet from prointegsy/src/Entity/Users.php: