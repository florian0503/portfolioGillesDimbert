<?php

namespace App\Entity;

use App\Repository\TemoignageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemoignageRepository::class)]
#[ORM\Table(name: 'temoignage')]
class Temoignage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private string $quote = '';

    #[ORM\Column(length: 255)]
    private string $authorName = '';

    #[ORM\Column(length: 255)]
    private string $authorRole = '';

    /** directions | dialogue_social | experts */
    #[ORM\Column(length: 50)]
    private string $category = 'directions';

    #[ORM\Column]
    private int $sortOrder = 0;

    #[ORM\Column]
    private bool $visible = true;

    public function getId(): ?int { return $this->id; }

    public function getQuote(): string { return $this->quote; }
    public function setQuote(string $quote): static { $this->quote = $quote; return $this; }

    public function getAuthorName(): string { return $this->authorName; }
    public function setAuthorName(string $authorName): static { $this->authorName = $authorName; return $this; }

    public function getAuthorRole(): string { return $this->authorRole; }
    public function setAuthorRole(string $authorRole): static { $this->authorRole = $authorRole; return $this; }

    public function getCategory(): string { return $this->category; }
    public function setCategory(string $category): static { $this->category = $category; return $this; }

    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $sortOrder): static { $this->sortOrder = $sortOrder; return $this; }

    public function isVisible(): bool { return $this->visible; }
    public function setVisible(bool $visible): static { $this->visible = $visible; return $this; }

    public function __toString(): string { return $this->authorName; }
}
