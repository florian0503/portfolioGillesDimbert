<?php

namespace App\Entity;

use App\Repository\RealisationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RealisationRepository::class)]
#[ORM\Table(name: 'realisation')]
class Realisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $sortOrder = 0;

    /** Libellé de l'onglet, ex: "Restructurations" */
    #[ORM\Column(length: 100)]
    private string $tabLabel = '';

    /** JSON: ["item 1", "item 2"] — colonne gauche "Contextes gérés" */
    #[ORM\Column(type: 'json')]
    private array $contextItems = [];

    /** Ex: "2 800" */
    #[ORM\Column(length: 50)]
    private string $bigNumber = '';

    /** Suffixe affiché en exposant après le nombre, ex: "+" ou "" */
    #[ORM\Column(length: 10)]
    private string $bigNumberSuffix = '+';

    /** Ex: "départs pilotés au total" */
    #[ORM\Column(length: 255)]
    private string $bigNumberLabel = '';

    /** JSON: ["item 1", "item 2"] — liste droite sous le grand chiffre */
    #[ORM\Column(type: 'json')]
    private array $resultItems = [];

    public function getId(): ?int { return $this->id; }

    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $sortOrder): static { $this->sortOrder = $sortOrder; return $this; }

    public function getTabLabel(): string { return $this->tabLabel; }
    public function setTabLabel(string $tabLabel): static { $this->tabLabel = $tabLabel; return $this; }

    public function getContextItems(): array { return $this->contextItems; }
    public function setContextItems(array $contextItems): static { $this->contextItems = $contextItems; return $this; }

    public function getBigNumber(): string { return $this->bigNumber; }
    public function setBigNumber(string $bigNumber): static { $this->bigNumber = $bigNumber; return $this; }

    public function getBigNumberSuffix(): string { return $this->bigNumberSuffix; }
    public function setBigNumberSuffix(string $bigNumberSuffix): static { $this->bigNumberSuffix = $bigNumberSuffix; return $this; }

    public function getBigNumberLabel(): string { return $this->bigNumberLabel; }
    public function setBigNumberLabel(string $bigNumberLabel): static { $this->bigNumberLabel = $bigNumberLabel; return $this; }

    public function getResultItems(): array { return $this->resultItems; }
    public function setResultItems(array $resultItems): static { $this->resultItems = $resultItems; return $this; }

    // ── Accesseurs JSON string pour EasyAdmin CodeEditorField ──────────────────

    public function getContextItemsText(): string
    {
        return implode("\n", $this->contextItems);
    }

    public function setContextItemsText(string $text): static
    {
        $this->contextItems = array_values(array_filter(array_map('trim', explode("\n", $text))));
        return $this;
    }

    public function getResultItemsText(): string
    {
        return implode("\n", $this->resultItems);
    }

    public function setResultItemsText(string $text): static
    {
        $this->resultItems = array_values(array_filter(array_map('trim', explode("\n", $text))));
        return $this;
    }

    public function __toString(): string { return $this->tabLabel; }
}
