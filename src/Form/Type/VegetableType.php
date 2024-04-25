<?php

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Vegetable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VegetableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'title',
            TextType::class, [
                // 'label' => 'vegetable name',
                // 'attr' => ['max_length' => 64],
                'required' => true,
            ]
            );
        $builder->add(
            'description',
            TextType::class, [
                // 'label' => 'vegetable description',
                // 'attr' => ['max_length' => 255],
                'required' => true,
            ]
            );
        $builder->add(
            'horizontalSpace',
            IntegerType::class, [
                // 'label' => 'enter horizontal space',
                'required' => true,          
            ]
            );
        $builder->add(
            'highLineSpace',
            IntegerType::class, [
                // 'label' => 'enter highLine space',
                'required' => true,
            ]
            );
        $builder->add(
            'siewingMonth',
            MonthChoiceType::class, [
                'required' => true,
            ]
        );

        $builder->add(
            'harvestMonth',
            MonthChoiceType::class, [
                'required' => true,
            ]
            );
        $builder->add(
            'category',
            EntityType::class,
            [
                'class' => Category::class,
                // 'choice_label' => function($category) {return $category->getTitle();},
                // 'label' => 'label_category',
                'required' => true,
                // 'placeholder' => 'choose_category'
            ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Vegetable::class,
            'csrf_protection' => false
            ]
        );
    }
}