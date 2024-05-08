<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    //USUNAC DWUSTRONNĄ

    // #[ORM\OneToMany(targetEntity: Vegetable::class, mappedBy: 'category')]
    // private Collection $vegetables;

    #[ORM\ManyToOne]
    private ?Species $species = null;

    // public function __construct()
    // {
    //     $this->vegetables = new ArrayCollection();
    // }

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

    // /**
    //  * @return Collection<int, Vegetable>
    //  */
    // public function getVegetables(): Collection
    // {
    //     return $this->vegetables;
    // }

    // public function addVegetable(Vegetable $vegetable): static
    // {
    //     if (!$this->vegetables->contains($vegetable)) {
    //         $this->vegetables->add($vegetable);
    //         $vegetable->setCategory($this);
    //     }

    //     return $this;
    // }

    // public function removeVegetable(Vegetable $vegetable): static
    // {
    //     if ($this->vegetables->removeElement($vegetable)) {
    //         // set the owning side to null (unless already changed)
    //         if ($vegetable->getCategory() === $this) {
    //             $vegetable->setCategory(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): void
    {
        $this->species = $species;
    }
}
