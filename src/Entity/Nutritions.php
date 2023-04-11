<?php

namespace App\Entity;

use App\Repository\NutritionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NutritionsRepository::class)]
class Nutritions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private ?int $fruit_id = null;

    #[ORM\Column(length: 255)]
    private ?string $fruit_carbohydrates = null;

    #[ORM\Column(length: 255)]
    private ?string $fruit_protein = null;

    #[ORM\Column(length: 255)]
    private ?string $fruit_fat = null;

    #[ORM\Column(length: 255)]
    private ?string $fruit_calories = null;

    #[ORM\Column(length: 255)]
    private ?string $fruit_sugar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFruitId(): ?int
    {
        return $this->fruit_id;
    }

    public function setFruitId(int $fruit_id): self
    {
        $this->fruit_id = $fruit_id;

        return $this;
    }

    public function getFruitCarbohydrates(): ?string
    {
        return $this->fruit_carbohydrates;
    }

    public function setFruitCarbohydrates(string $fruit_carbohydrates): self
    {
        $this->fruit_carbohydrates = $fruit_carbohydrates;

        return $this;
    }

    public function getFruitProtein(): ?string
    {
        return $this->fruit_protein;
    }

    public function setFruitProtein(string $fruit_protein): self
    {
        $this->fruit_protein = $fruit_protein;

        return $this;
    }

    public function getFruitFat(): ?string
    {
        return $this->fruit_fat;
    }

    public function setFruitFat(string $fruit_fat): self
    {
        $this->fruit_fat = $fruit_fat;

        return $this;
    }

    public function getFruitCalories(): ?string
    {
        return $this->fruit_calories;
    }

    public function setFruitCalories(string $fruit_calories): self
    {
        $this->fruit_calories = $fruit_calories;

        return $this;
    }

    public function getFruitSugar(): ?string
    {
        return $this->fruit_sugar;
    }

    public function setFruitSugar(string $fruit_sugar): self
    {
        $this->fruit_sugar = $fruit_sugar;

        return $this;
    }
}
