<?php

namespace App\Resolver;

use App\Dto\VegetableListInputFiltersDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class VegetableListInputFiltersDtoResolver implements ValueResolverInterface
{

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if(!$argumentType || !is_a($argumentType, VegetableListInputFiltersDto::class, true)) {
            return [];
        }

        $categoryId = $request->query->get('categoryId');

        return [new VegetableListInputFiltersDto($categoryId)];
    }

}

