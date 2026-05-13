<?php

namespace App\Entity;

use App\Repository\ContactInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité singleton — une seule ligne en base (id=1).
 */
#[ORM\Entity(repositoryClass: ContactInfoRepository::class)]
#[ORM\Table(name: 'contact_info')]
class ContactInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private string $phone = '';

    #[ORM\Column(length: 255)]
    private string $email = '';

    #[ORM\Column(length: 255)]
    private string $linkedin = '';

    #[ORM\Column(length: 100)]
    private string $location = '';

    /** Ex: "juin 2026" */
    #[ORM\Column(length: 100)]
    private string $availability = '';

    /** Texte affiché sous les coordonnées, ex: "Juge prud'homal depuis 2002" */
    #[ORM\Column(length: 255)]
    private string $extraInfo = '';

    public function getId(): ?int { return $this->id; }

    public function getPhone(): string { return $this->phone; }
    public function setPhone(string $phone): static { $this->phone = $phone; return $this; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }

    public function getLinkedin(): string { return $this->linkedin; }
    public function setLinkedin(string $linkedin): static { $this->linkedin = $linkedin; return $this; }

    public function getLocation(): string { return $this->location; }
    public function setLocation(string $location): static { $this->location = $location; return $this; }

    public function getAvailability(): string { return $this->availability; }
    public function setAvailability(string $availability): static { $this->availability = $availability; return $this; }

    public function getExtraInfo(): string { return $this->extraInfo; }
    public function setExtraInfo(string $extraInfo): static { $this->extraInfo = $extraInfo; return $this; }

    public function __toString(): string { return 'Informations de contact'; }
}
