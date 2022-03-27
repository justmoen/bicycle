<?php

namespace App\Form;

use App\Document\FrontDerailleur;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class FrontDerailleurType extends AbstractComponentType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('maxCogCount', IntegerType::class)
            ->add('minCogSize', IntegerType::class)
            ->add('maxCogSize', IntegerType::class)
            ->add('pullType', ChoiceType::class, [
            'choices' => [
                FrontDerailleur::PULL_TYPE_UP => FrontDerailleur::PULL_TYPE_UP,
                FrontDerailleur::PULL_TYPE_DOWN => FrontDerailleur::PULL_TYPE_DOWN
            ]
        ]);
    }
}