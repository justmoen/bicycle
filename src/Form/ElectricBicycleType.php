<?php

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;

class ElectricBicycleType extends AbstractBicycleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('batteryCapacity');
    }
}