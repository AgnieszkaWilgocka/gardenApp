<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PatchRepository;

#[ORM\Entity(repositoryClass: PatchRepository::class)]
class Patch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $heightPatch = null;

    #[ORM\Column]
    private ?int $widthPatch = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getHeightPatch(): ?int
    {
        return $this->heightPatch;
    }

    public function setHeightPatch(int $heightPatch): void
    {
        $this->heightPatch = $heightPatch;
    }

    public function getWidthPatch(): ?int
    {
        return $this->widthPatch;
    }

    public function setWidthPatch(int $widthPatch): void
    {
        $this->widthPatch = $widthPatch;
    }
}
