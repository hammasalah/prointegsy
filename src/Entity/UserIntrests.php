<?php

namespace App\Entity;

use App\Repository\UserIntrestsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserIntrestsRepository::class)]
#[ORM\Table(name: "UserIntrests")]
class UserIntrests
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?Users $user_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "category_id", referencedColumnName: "id")]
    private ?Category $category_id = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCategoryId(): ?Category
    {
        return $this->category_id;
    }

    public function setCategoryId(?Category $category_id): static
    {
        $this->category_id = $category_id;

        return $this;
    }
}
