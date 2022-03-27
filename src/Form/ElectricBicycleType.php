<?php

namespace App\Form;

use App\Form\Abstract\AbstractBicycleType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class ElectricBicycleType extends AbstractBicycleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('batteryCapacity', NumberType::class);
    }
}