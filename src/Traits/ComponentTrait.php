<?php

namespace App\Traits;

use App\Document\Interface\ComponentInterface;
use App\Form\Component\AbstractComponentType;
use Symfony\Component\Form\FormInterface;

trait ComponentTrait
{
    /**
     * @param string $class
     * @param ComponentInterface $component
     * @return FormInterface
     */
    public function getForm(string $class, ComponentInterface $component): FormInterface
    {
        return $this->createForm(
            $this->matchClassToFormTypeService->getTypeClass(
                $class,
                AbstractComponentType::class
            ), $component
        );
    }
}