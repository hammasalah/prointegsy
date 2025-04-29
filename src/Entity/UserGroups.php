<?php

namespace App\Entity;

use App\Repository\UserGroupsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserGroupsRepository::class)]
#[ORM\Table(name: "UserGroups")]
class UserGroups
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "group_id", type: "integer")]
    private ?int $groupId = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $profile_picture = null;

    #[ORM\Column(length: 255)]
    private ?string $rules = null;

    #[ORM\Column(length: 255)]
    private ?string $created_at = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $creator_id = null;

    public function getId(): ?int
    {
        return $this->groupId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profile_picture;
    }

    public function setProfilePicture(string $profile_picture): static
    {
        $this->profile_picture = $profile_picture;

        return $this;
    }

    public function getRules(): ?string
    {
        return $this->rules;
    }

    public function setRules(string $rules): static
    {
        $this->rules = $rules;

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatorId(): ?Users
    {
        return $this->creator_id;
    }

    public function setCreatorId(?Users $creator_id): static
    {
        $this->creator_id = $creator_id;

        return $this;
    }
}
