<?php

namespace App\Entity;

use App\Repository\UserRewardsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRewardsRepository::class)]
class UserRewards
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column]
    private ?int $reward_id = null;

    #[ORM\Column]
    private ?int $event_id = null;

    #[ORM\Column]
    private ?int $points_earned = null;

    #[ORM\Column (length: 255)]
    private ?string $erned_at = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRewardId(): ?int
    {
        return $this->reward_id;
    }

    public function setRewardId(int $reward_id): static
    {
        $this->reward_id = $reward_id;

        return $this;
    }

    public function getEventId(): ?int
    {
        return $this->event_id;
    }

    public function setEventId(int $event_id): static
    {
        $this->event_id = $event_id;

        return $this;
    }

    public function getPointsEarned() : ?int
    {
        return $this->points_earned;
    }

    public function setPointsEarned(int $points_earned): static
    {
        $this->points_earned = $points_earned;

        return $this;
    }

    public function getErnedAt(): ?string
    {
        return $this->erned_at;
    }

    public function setErnedAt(string $erned_at): static
    {
        $this->erned_at = $erned_at;

        return $this;
    }
}
