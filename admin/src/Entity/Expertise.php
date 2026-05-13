<?php

namespace App\Entity;

use App\Repository\ExpertiseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpertiseRepository::class)]
#[ORM\Table(name: 'expertise')]
class Expertise
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
    private string $description = '';

    #[ORM\Column]
    private bool $visible = true;

    public function getId(): ?int { return $this->id; }

    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $sortOrder): static { $this->sortOrder = $sortOrder; return $this; }

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): static { $this->title = $title; return $this; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): static { $this->description = $description; return $this; }

    public function isVisible(): bool { return $this->visible; }
    public function setVisible(bool $visible): static { $this->visible = $visible; return $this; }

    public function __toString(): string { return $this->title; }
}
