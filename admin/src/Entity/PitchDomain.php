<?php

namespace App\Entity;

use App\Repository\PitchDomainRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PitchDomainRepository::class)]
#[ORM\Table(name: 'pitch_domain')]
class PitchDomain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $sortOrder = 0;

    #[ORM\Column(length: 255)]
    private string $title = '';

    #[ORM\Column(type: 'text')]
    private string $text = '';

    public function getId(): ?int { return $this->id; }

    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $sortOrder): static { $this->sortOrder = $sortOrder; return $this; }

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): static { $this->title = $title; return $this; }

    public function getText(): string { return $this->text; }
    public function setText(string $text): static { $this->text = $text; return $this; }

    public function __toString(): string { return $this->title; }
}
