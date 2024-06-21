<?php

namespace App\Form\Type;

use App\Entity\Patch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'required' => true,
            ]
            );

        $builder->add(
            'heightPatch',
            IntegerType::class,
            [
                'required' => true,
            ]
            );
        $builder->add(
            'widthPatch',
            IntegerType::class,
            [
                'required' => true,
            ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Patch::class, 
                'csrf_protection' => false,
            ]
            );
    }
}