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
            ->add('maxCogCount', IntegerType::class)
            ->add('minCogSize', IntegerType::class)
            ->add('maxCogSize', IntegerType::class);
    }
}