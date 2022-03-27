<?php

namespace App\Form\Component;

use App\Document\Component\FrontDerailleur;
use App\Form\Abstract\AbstractComponentType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class FrontDerailleurType extends AbstractComponentType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('maxCogCount', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 3
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
            ])
            ->add('pullType', ChoiceType::class, [
                'choices' => [
                    FrontDerailleur::PULL_TYPE_UP => FrontDerailleur::PULL_TYPE_UP,
                    FrontDerailleur::PULL_TYPE_DOWN => FrontDerailleur::PULL_TYPE_DOWN
            ]
        ]);
    }
}