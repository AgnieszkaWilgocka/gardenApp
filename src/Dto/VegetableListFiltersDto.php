<?php

namespace App\Dto;

use App\Entity\Category;

class VegetableListFiltersDto
{
    public function __construct(public readonly ?Category $category)
    {}
}



