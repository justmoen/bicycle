<?php

namespace App\Form;

use App\Document\Abstract\AbstractComponent;
use App\Document\Component\FrontDerailleur;
use App\Document\Component\RearDerailleur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SelectComponentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('componentType', ChoiceType::class, [
                'label' => 'Select Component Type',
                'choices' => [
                    AbstractComponent::COMPONENT_TYPE_FRONT_DERAILLEUR => FrontDerailleur::class,
                    AbstractComponent::COMPONENT_TYPE_REAR_DERAILLEUR => RearDerailleur::class
                ]
            ])
            ->add('next', SubmitType::class);
    }
}