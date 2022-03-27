<?php

namespace App\Form;

use App\Document\AbstractBicycle;
use App\Document\ElectricBicycle;
use App\Document\MountainBicycle;
use App\Document\RoadBicycle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class BicycleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bicycleType', ChoiceType::class, [
                'label' => 'Select Bicycle Type',
                'choices' => [
                    AbstractBicycle::BICYCLE_TYPE_ELECTRIC => ElectricBicycle::class,
                    AbstractBicycle::BICYCLE_TYPE_ROAD => RoadBicycle::class,
                    AbstractBicycle::BICYCLE_TYPE_MOUNTAIN => MountainBicycle::class
                ]
            ])
            ->add('next', SubmitType::class);
    }
}