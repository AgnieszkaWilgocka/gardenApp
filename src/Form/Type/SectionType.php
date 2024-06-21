<?php

namespace App\Form\Type;

use App\Entity\Patch;
use App\Entity\Section;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'columnSection',
            IntegerType::class,
            [
                'required' => true,
            ]
            );
        $builder->add(
            'rowSection',
            IntegerType::class,
            [
                'required' => true,
            ]
            );
        $builder->add(
            'patches',
            EntityType::class,
            [
                'class' => Patch::class,
                'required' => true
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {   
        $resolver->setDefaults(
            [
                'data_class' => Section::class,
                'csrf_protection' => false,
            ]
            );
        
    }
}