<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Users;

#[ORM\Entity]
#[ORM\Table(name: 'roulette')]
class Roulette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'roulettes')]
    #[ORM\JoinColumn(name: "user_id", nullable: false)]
    private ?Users $user = null;
    
    #[ORM\Column(name: "user_id", type: 'integer', insertable: false, updatable: false)]
    private ?int $user_id = null;

    #[ORM\Column(type: 'datetime', name: "date")]
    private \DateTime $date;
    
    #[ORM\Column(type: 'integer')]
    private int $points_gagnes = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }
    
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;
        return $this;
    }
    
    public function getPointsGagnes(): ?int
    {
        return $this->points_gagnes;
    }
    
    public function setPointsGagnes(int $points_gagnes): self
    {
        $this->points_gagnes = $points_gagnes;
        return $this;
    }
}