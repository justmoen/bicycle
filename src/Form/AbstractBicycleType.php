<?php

namespace App\Form;

use App\Document\FrontDerailleur;
use App\Document\RearDerailleur;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractBicycleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type', HiddenType::class)
            ->add('frontDerailleur', DocumentType::class, [
                'class' => FrontDerailleur::class,
                'mapped' => false,
                'choice_label' => 'name'
            ])
            ->add('rearDerailleur', DocumentType::class, [
                'class' => RearDerailleur::class,
                'mapped' => false,
                'choice_label' => 'name'
            ])
            ->add('submit', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'componentSets' => []
        ]);
    }

}