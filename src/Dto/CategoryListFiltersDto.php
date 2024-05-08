<?php

namespace App\Dto;

use App\Entity\Species;

class CategoryListFiltersDto
{
    public function __construct(public readonly ?Species $species)
    {
    }
}