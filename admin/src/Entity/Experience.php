<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
#[ORM\Table(name: 'experience')]
class Experience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $sortOrder = 0;

    #[ORM\Column(length: 50)]
    private string $period = '';

    /** transition | cdi | cdd */
    #[ORM\Column(length: 20)]
    private string $type = 'cdi';

    #[ORM\Column(length: 255)]
    private string $company = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companySubtitle = null;

    #[ORM\Column(length: 255)]
    private string $role = '';

    #[ORM\Column(type: 'text')]
    private string $context = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    /** JSON: [{"label":"...", "items":["..."]}] */
    #[ORM\Column(type: 'json')]
    private array $detailGroups = [];

    /** JSON: [{"label":"...", "url":"..."}] */
    #[ORM\Column(type: 'json')]
    private array $externalLinks = [];

    /** JSON: ["Transition", "700 sal.", ...] */
    #[ORM\Column(type: 'json')]
    private array $tags = [];

    public function getId(): ?int { return $this->id; }

    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $sortOrder): static { $this->sortOrder = $sortOrder; return $this; }

    public function getPeriod(): string { return $this->period; }
    public function setPeriod(string $period): static { $this->period = $period; return $this; }

    public function getType(): string { return $this->type; }
    public function setType(string $type): static { $this->type = $type; return $this; }

    public function getCompany(): string { return $this->company; }
    public function setCompany(string $company): static { $this->company = $company; return $this; }

    public function getCompanySubtitle(): ?string { return $this->companySubtitle; }
    public function setCompanySubtitle(?string $companySubtitle): static { $this->companySubtitle = $companySubtitle; return $this; }

    public function getRole(): string { return $this->role; }
    public function setRole(string $role): static { $this->role = $role; return $this; }

    public function getContext(): string { return $this->context; }
    public function setContext(string $context): static { $this->context = $context; return $this; }

    public function getLogo(): ?string { return $this->logo; }
    public function setLogo(?string $logo): static { $this->logo = $logo; return $this; }

    public function getDetailGroups(): array { return $this->detailGroups; }
    public function setDetailGroups(array $detailGroups): static { $this->detailGroups = $detailGroups; return $this; }

    public function getExternalLinks(): array { return $this->externalLinks; }
    public function setExternalLinks(array $externalLinks): static { $this->externalLinks = $externalLinks; return $this; }

    public function getTags(): array { return $this->tags; }
    public function setTags(array $tags): static { $this->tags = $tags; return $this; }

    // ── Accesseurs JSON string pour EasyAdmin CodeEditorField ──────────────────

    /** Une ligne par tag */
    public function getTagsText(): string
    {
        return implode("\n", $this->tags);
    }

    public function setTagsText(string $text): static
    {
        $this->tags = array_values(array_filter(array_map('trim', explode("\n", $text))));
        return $this;
    }

    /**
     * Format : "Label|https://url.com" — une ligne par lien.
     * Si pas de séparateur |, le label = l'URL.
     */
    public function getExternalLinksText(): string
    {
        return implode("\n", array_map(
            fn($l) => ($l['label'] ?? '') . '|' . ($l['url'] ?? ''),
            $this->externalLinks
        ));
    }

    public function setExternalLinksText(string $text): static
    {
        $this->externalLinks = [];
        foreach (array_filter(array_map('trim', explode("\n", $text))) as $line) {
            [$label, $url] = array_pad(explode('|', $line, 2), 2, $line);
            $this->externalLinks[] = ['label' => trim($label), 'url' => trim($url)];
        }
        return $this;
    }

    /**
     * Format dans l'admin :
     *   Titre du groupe
     *   - Détail 1
     *   - Détail 2
     *
     *   Autre groupe
     *   - Détail A
     *
     * Ligne indentée ou commençant par - / • / * = item.
     * Toute autre ligne non vide = titre de groupe.
     */
    public function getDetailGroupsText(): string
    {
        $lines = [];
        foreach ($this->detailGroups as $group) {
            if ($group['label'] ?? '') {
                $lines[] = $group['label'];
            }
            foreach ($group['items'] ?? [] as $item) {
                $lines[] = '- ' . $item;
            }
            $lines[] = '';
        }
        return trim(implode("\n", $lines));
    }

    public function setDetailGroupsText(string $text): static
    {
        // Normalise les fins de ligne (Windows \r\n, ancien Mac \r, Unix \n)
        $normalized = str_replace(["\r\n", "\r"], "\n", $text);
        $lines = explode("\n", $normalized);

        $groups = [];
        $current = null;

        foreach ($lines as $raw) {
            $line = trim($raw);

            if ($line === '') {
                continue;
            }

            // Détecte un item : commence par -, –, —, •, *, ou un espace/tab
            if (preg_match('/^[-–—•*]\s*/u', $line) || preg_match('/^\s+/', $raw)) {
                // Supprime le préfixe (tiret/puce + espaces)
                $item = trim(preg_replace('/^[-–—•*]\s*/u', '', $line));
                if ($item === '') continue;

                if ($current === null) {
                    $current = ['label' => '', 'items' => []];
                }
                $current['items'][] = $item;
            } else {
                // Nouvelle ligne sans préfixe = titre de groupe
                if ($current !== null) {
                    $groups[] = $current;
                }
                $current = ['label' => $line, 'items' => []];
            }
        }

        if ($current !== null) {
            $groups[] = $current;
        }

        // Assigne une nouvelle référence pour que Doctrine détecte le changement
        $this->detailGroups = $groups;

        return $this;
    }

    public function __toString(): string { return $this->company . ' (' . $this->period . ')'; }
}
