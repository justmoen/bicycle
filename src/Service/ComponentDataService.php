<?php

namespace App\Service;

use App\Document\Interface\ComponentInterface;
use Symfony\Component\Form\FormInterface;

class ComponentDataService
{
    /**
     * @param FormInterface $form
     * @param ComponentInterface $mockComponent
     * @return ComponentInterface
     */
    public function processFormData(
        FormInterface $form,
        ComponentInterface $mockComponent
    ): ComponentInterface {
        /**
         * @var ComponentInterface $component
         */
        $component = $form->getData();
        $component->setType($mockComponent->getType());
        return $component;
    }
}