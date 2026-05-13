<?php

namespace App\Entity;

use App\Repository\SourceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SourceRepository::class)]
#[ORM\Table(name: 'source')]
class Source
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $sortOrder = 0;

    /** Ex: "L'Argus", "Journal Officiel" */
    #[ORM\Column(length: 100)]
    private string $badge = '';

    #[ORM\Column(length: 255)]
    private string $title = '';

    #[ORM\Column(length: 500)]
    private string $url = '';

    #[ORM\Column]
    private bool $visible = true;

    public function getId(): ?int { return $this->id; }

    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $sortOrder): static { $this->sortOrder = $sortOrder; return $this; }

    public function getBadge(): string { return $this->badge; }
    public function setBadge(string $badge): static { $this->badge = $badge; return $this; }

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): static { $this->title = $title; return $this; }

    public function getUrl(): string { return $this->url; }
    public function setUrl(string $url): static { $this->url = $url; return $this; }

    public function isVisible(): bool { return $this->visible; }
    public function setVisible(bool $visible): static { $this->visible = $visible; return $this; }

    public function __toString(): string { return $this->badge . ' — ' . $this->title; }
}
