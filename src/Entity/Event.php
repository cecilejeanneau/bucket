<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $daterangeFr = null;

    #[ORM\Column(length: 255)]
    private ?string $thumbnail = null;

    #[ORM\Column(length: 255)]
    private ?string $titleFr = null;

    #[ORM\Column(length: 255)]
    private ?string $locationName = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $locationAdresse = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionFr = null;

    #[ORM\Column(length: 255)]
    private ?string $canonicalurl = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDaterangeFr(): ?\DateTimeInterface
    {
        return $this->daterangeFr;
    }

    public function setDaterangeFr(\DateTimeInterface $daterangeFr): static
    {
        $this->daterangeFr = $daterangeFr;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getTitleFr(): ?string
    {
        return $this->titleFr;
    }

    public function setTitleFr(string $titleFr): static
    {
        $this->titleFr = $titleFr;

        return $this;
    }

    public function getLocationName(): ?string
    {
        return $this->locationName;
    }

    public function setLocationName(string $locationName): static
    {
        $this->locationName = $locationName;

        return $this;
    }

    public function getLocationAdresse(): ?string
    {
        return $this->locationAdresse;
    }

    public function setLocationAdresse(string $locationAdresse): static
    {
        $this->locationAdresse = $locationAdresse;

        return $this;
    }

    public function getDescriptionFr(): ?string
    {
        return $this->descriptionFr;
    }

    public function setDescriptionFr(string $descriptionFr): static
    {
        $this->descriptionFr = $descriptionFr;

        return $this;
    }

    public function getCanonicalurl(): ?string
    {
        return $this->canonicalurl;
    }

    public function setCanonicalurl(string $canonicalurl): static
    {
        $this->canonicalurl = $canonicalurl;

        return $this;
    }
}
