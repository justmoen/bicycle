<?php

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;

class FrontDerailleurType extends AbstractComponentType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('pullType');
    }
}