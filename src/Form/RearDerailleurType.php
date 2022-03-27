<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class RearDerailleurType extends AbstractComponentType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('maxCogCount', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 13
                    ],
                'data' => 1
            ])
            ->add('minCogSize', IntegerType::class, [
                'attr' => [
                    'min' => 9,
                    'max' => 15
                    ],
                'data' => 9
            ])
            ->add('maxCogSize', IntegerType::class, [
                'attr' => [
                    'min' => 26,
                    'max' => 56
                    ],
                'data' => 26
            ]);
    }
}