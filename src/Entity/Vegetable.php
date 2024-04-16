<?php

namespace App\Entity;

use App\Repository\VegetableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VegetableRepository::class)]
class Vegetable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $horizontalSpace = null;

    #[ORM\Column]
    private ?int $highLineSpace = null;

    #[ORM\Column(length: 255)]
    private ?string $siewingMonth = null;

    #[ORM\Column(length: 255)]
    private ?string $harvestMonth = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getHorizontalSpace(): ?int
    {
        return $this->horizontalSpace;
    }

    public function setHorizontalSpace(int $horizontalSpace): void
    {
        $this->horizontalSpace = $horizontalSpace;
    }

    public function getHighLineSpace(): ?int
    {
        return $this->highLineSpace;
    }

    public function setHighLineSpace(int $highLineSpace): void
    {
        $this->highLineSpace = $highLineSpace;
    }

    public function getSiewingMonth(): ?string
    {
        return $this->siewingMonth;
    }

    public function setSiewingMonth(string $siewingMonth): void
    {
        $this->siewingMonth = $siewingMonth;
    }

    public function getHarvestMonth(): ?string
    {
        return $this->harvestMonth;
    }

    public function setHarvestMonth(string $harvestMonth): void
    {
        $this->harvestMonth = $harvestMonth;
    }
}
