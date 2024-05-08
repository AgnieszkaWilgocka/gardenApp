<?php

namespace App\Dto;

class CategoryListInputFiltersDto
{
    public function __construct(public readonly ?int $speciesId)
    {}
}