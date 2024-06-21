<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $columnSection = null;

    #[ORM\Column]
    private ?int $rowSection = null;

    #[ORM\ManyToOne]
    private ?Patch $patches = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColumnSection(): ?int
    {
        return $this->columnSection;
    }

    public function setColumnSection(int $columnSection): void
    {
        $this->columnSection = $columnSection;
    }

    public function getRowSection(): ?int
    {
        return $this->rowSection;
    }

    public function setRowSection(int $rowSection): void
    {
        $this->rowSection = $rowSection;
    }

    public function getPatches(): ?Patch
    {
        return $this->patches;
    }

    public function setPatches(?Patch $patches): void
    {
        $this->patches = $patches;
    }
}
