<?php

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Species;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'category_title',
                'required' => true,
                'attr' => ['max_length' => 64]
            ]
            );
        $builder->add(
            'species',
            EntityType::class,
            [
                'class' => Species::class,
                'required' => true
            ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Category::class,
                'csrf_protection' => false
            ]
            );
    }
}