<?php

namespace App\Form;

use App\Document\Component\AbstractComponent;
use App\Document\Component\FrontDerailleur;
use App\Document\Component\RearDerailleur;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractBicycleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('frontDerailleur', DocumentType::class, [
                'class' => FrontDerailleur::class,
                'mapped' => false,
                'choice_label' => 'name',
                'data' => $options[AbstractComponent::COMPONENT_TYPE_FRONT_DERAILLEUR]
            ])
            ->add('rearDerailleur', DocumentType::class, [
                'class' => RearDerailleur::class,
                'mapped' => false,
                'choice_label' => 'name',
                'data' => $options[AbstractComponent::COMPONENT_TYPE_REAR_DERAILLEUR]
            ])
            ->add('submit', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'componentSets' => [],
            AbstractComponent::COMPONENT_TYPE_FRONT_DERAILLEUR => null,
            AbstractComponent::COMPONENT_TYPE_REAR_DERAILLEUR => null
        ]);
    }

}