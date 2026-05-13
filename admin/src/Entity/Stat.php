<?php

namespace App\Entity;

use App\Repository\StatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatRepository::class)]
#[ORM\Table(name: 'stat')]
class Stat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $sortOrder = 0;

    #[ORM\Column]
    private int $target = 0;

    /** suffix affiché après le chiffre, ex: "+" ou "" */
    #[ORM\Column(length: 10)]
    private string $suffix = '+';

    #[ORM\Column(length: 255)]
    private string $label = '';

    public function getId(): ?int { return $this->id; }

    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $sortOrder): static { $this->sortOrder = $sortOrder; return $this; }

    public function getTarget(): int { return $this->target; }
    public function setTarget(int $target): static { $this->target = $target; return $this; }

    public function getSuffix(): string { return $this->suffix; }
    public function setSuffix(string $suffix): static { $this->suffix = $suffix; return $this; }

    public function getLabel(): string { return $this->label; }
    public function setLabel(string $label): static { $this->label = $label; return $this; }

    public function __toString(): string { return $this->target . $this->suffix . ' — ' . $this->label; }
}
