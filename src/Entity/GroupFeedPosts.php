<?php

namespace App\Entity;

use App\Repository\GroupFeedPostsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupFeedPostsRepository::class)]
class GroupFeedPosts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserGroups $group_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $timestamp = null;

    #[ORM\Column(length: 255)]
    private ?string $media_url = null;

    #[ORM\Column(nullable: true)]
    private ?int $is_deleted = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupId(): ?UserGroups
    {
        return $this->group_id;
    }

    public function setGroupId(?UserGroups $group_id): static
    {
        $this->group_id = $group_id;

        return $this;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getTimestamp(): ?string
    {
        return $this->timestamp;
    }

    public function setTimestamp(string $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getMediaUrl(): ?string
    {
        return $this->media_url;
    }

    public function setMediaUrl(string $media_url): static
    {
        $this->media_url = $media_url;

        return $this;
    }

    public function getIsDeleted(): ?int
    {
        return $this->is_deleted;
    }

    public function setIsDeleted(?int $is_deleted): static
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }
}
