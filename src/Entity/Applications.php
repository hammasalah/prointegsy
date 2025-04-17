<?php

namespace App\Entity;

use App\Repository\ApplicationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationsRepository::class)]
class Applications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Events $enevt_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Jobs $job_id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $appliedAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $rewarded = null;

    #[ORM\Column(length: 255)]
    private ?string $cover_letter = null;

    #[ORM\Column(length: 255)]
    private ?string $resume_path = null;

    #[ORM\Column(nullable: true)]
    private ?int $coverRating = null;

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

    public function getEnevtId(): ?Events
    {
        return $this->enevt_id;
    }

    public function setEnevtId(?Events $enevt_id): static
    {
        $this->enevt_id = $enevt_id;

        return $this;
    }

    public function getJobId(): ?Jobs
    {
        return $this->job_id;
    }

    public function setJobId(?Jobs $job_id): static
    {
        $this->job_id = $job_id;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAppliedAt(): ?string
    {
        return $this->appliedAt;
    }

    public function setAppliedAt(?string $appliedAt): static
    {
        $this->appliedAt = $appliedAt;

        return $this;
    }

    public function getRewarded(): ?int
    {
        return $this->rewarded;
    }

    public function setRewarded(?int $rewarded): static
    {
        $this->rewarded = $rewarded;

        return $this;
    }

    public function getCoverLetter(): ?string
    {
        return $this->cover_letter;
    }

    public function setCoverLetter(string $cover_letter): static
    {
        $this->cover_letter = $cover_letter;

        return $this;
    }

    public function getResumePath(): ?string
    {
        return $this->resume_path;
    }

    public function setResumePath(string $resume_path): static
    {
        $this->resume_path = $resume_path;

        return $this;
    }

    public function getCoverRating(): ?int
    {
        return $this->coverRating;
    }

    public function setCoverRating(?int $coverRating): static
    {
        $this->coverRating = $coverRating;

        return $this;
    }
}
