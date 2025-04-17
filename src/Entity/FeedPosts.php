<?php

namespace App\Entity;

use App\Repository\FeedPostsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedPostsRepository::class)]
class FeedPosts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $userId = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $timeStamp = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $eventId = null;

    #[ORM\Column(nullable: true)]
    private ?int $isDeleted = null;

    #[ORM\Column(length: 255)]
    private ?string $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $scorePopularite = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePath = null;

    #[ORM\Column(nullable: true)]
    private ?int $groupId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?Users
    {
        return $this->userId;
    }

    public function setUserId(?Users $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getTimeStamp(): ?string
    {
        return $this->timeStamp;
    }

    public function setTimeStamp(string $timeStamp): static
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }

    public function getEventId(): ?Users
    {
        return $this->eventId;
    }

    public function setEventId(?Users $eventId): static
    {
        $this->eventId = $eventId;

        return $this;
    }

    public function getIsDeleted(): ?int
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?int $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

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

    public function setUpdatedAt(string $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getScorePopularite(): ?int
    {
        return $this->scorePopularite;
    }

    public function setScorePopularite(?int $scorePopularite): static
    {
        $this->scorePopularite = $scorePopularite;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function setGroupId(?int $groupId): static
    {
        $this->groupId = $groupId;

        return $this;
    }
}
