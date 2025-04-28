<?php

namespace App\Entity;

use App\Repository\GroupMembersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupMembersRepository::class)]
#[ORM\Table(name: "GroupMembers")]
class GroupMembers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserGroups $group_it = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupIt(): ?UserGroups
    {
        return $this->group_it;
    }

    public function setGroupIt(?UserGroups $group_it): static
    {
        $this->group_it = $group_it;

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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }
}
