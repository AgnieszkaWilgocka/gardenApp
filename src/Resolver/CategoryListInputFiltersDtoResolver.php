<?php

namespace App\Resolver;

use App\Dto\CategoryListInputFiltersDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class CategoryListInputFiltersDtoResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if(!$argumentType || !is_a($argumentType, CategoryListInputFiltersDto::class, true)) {
            return [];
        }

        $speciesId = $request->query->get('speciesId');

        return [new CategoryListInputFiltersDto($speciesId)];
    }
}