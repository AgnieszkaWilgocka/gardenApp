<?php


namespace App\Dto;

class VegetableListInputFiltersDto
{
    public function __construct(public readonly ?int $categoryId = null)
    {
    }
}