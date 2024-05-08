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
    private ?string $siewingMonthStart = null;

    #[ORM\Column(length: 255)]
    private ?string $harvestMonthStart = null;

    #[ORM\ManyToOne(inversedBy: 'vegetables')]
    private ?Category $category = null;

    #[ORM\Column(length: 255)]
    private ?string $siewingMonthEnd = null;

    #[ORM\Column(length: 255)]
    private ?string $harvestMonthEnd = null;

    #[ORM\Column(length: 255)]
    private ?string $seedlingPlantingMonth = null;

    #[ORM\Column(length: 255)]
    private ?string $seedlingMoveToGroundMonth = null;

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

    public function getSiewingMonthStart(): ?string
    {
        return $this->siewingMonthStart;
    }

    public function setSiewingMonthStart(string $siewingMonth): void
    {
        $this->siewingMonthStart = $siewingMonth;
    }

    public function getHarvestMonthStart(): ?string
    {
        return $this->harvestMonthStart;
    }

    public function setHarvestMonthStart(string $harvestMonth): void
    {
        $this->harvestMonthStart = $harvestMonth;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    public function getSiewingMonthEnd(): ?string
    {
        return $this->siewingMonthEnd;
    }

    public function setSiewingMonthEnd(string $siewingMonthEnd): void
    {
        $this->siewingMonthEnd = $siewingMonthEnd;
    }

    public function getHarvestMonthEnd(): ?string
    {
        return $this->harvestMonthEnd;
    }

    public function setHarvestMonthEnd(string $harvestMonthEnd): void
    {
        $this->harvestMonthEnd = $harvestMonthEnd;
    }

    public function getSeedlingPlantingMonth(): ?string
    {
        return $this->seedlingPlantingMonth;
    }

    public function setSeedlingPlantingMonth(string $seedlingPlantingMonth): void
    {
        $this->seedlingPlantingMonth = $seedlingPlantingMonth;
    }

    public function getSeedlingMoveToGroundMonth(): ?string
    {
        return $this->seedlingMoveToGroundMonth;
    }

    public function setSeedlingMoveToGroundMonth(string $SeedlingMoveToGroundMonth): void
    {
        $this->seedlingMoveToGroundMonth = $SeedlingMoveToGroundMonth;
    }
}
