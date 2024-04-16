<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MonthChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'label' => 'choose month',
                'choices' => $this->getChoices(),
            ]
            );
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    protected function getChoices(): array
    {
        $monthChoices = [
            'January' => "January",
            'Fabruary' => "Fabruary",
            'March' => "March",
            'April' => "April",
            'May' => "May",
            'June' => "June",
            'July' => "July",
            'August' => "August",
            'September' => "September",
            'October' => "October",
            'November' => "November",
            'December' => "December",
        ];

        return $monthChoices;
    }
}