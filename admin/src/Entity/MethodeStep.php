<?php

namespace App\Entity;

use App\Repository\MethodeStepRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MethodeStepRepository::class)]
#[ORM\Table(name: 'methode_step')]
class MethodeStep
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $sortOrder = 0;

    /** Ex: "J+30" */
    #[ORM\Column(length: 20)]
    private string $day = '';

    /** Ex: "Compréhension & prise de contrôle" */
    #[ORM\Column(length: 255)]
    private string $tag = '';

    #[ORM\Column(type: 'text')]
    private string $description = '';

    public function getId(): ?int { return $this->id; }

    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $sortOrder): static { $this->sortOrder = $sortOrder; return $this; }

    public function getDay(): string { return $this->day; }
    public function setDay(string $day): static { $this->day = $day; return $this; }

    public function getTag(): string { return $this->tag; }
    public function setTag(string $tag): static { $this->tag = $tag; return $this; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): static { $this->description = $description; return $this; }

    public function __toString(): string { return $this->day . ' — ' . $this->tag; }
}
