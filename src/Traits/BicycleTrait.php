<?php

namespace App\Traits;

use App\Document\Interface\BicycleInterface;
use App\Form\AbstractBicycleType;
use Symfony\Component\Form\FormInterface;

trait BicycleTrait
{
    /**
     * @param string $class
     * @param BicycleInterface $bicycle
     * @return FormInterface
     */
    public function getForm(string $class, BicycleInterface $bicycle): FormInterface
    {
        $options = ['componentSets' => $this->componentSetService->getAll()];
        foreach ($bicycle->getComponents() as $component) {
            $options[$component->getType()] = $component;
        }
        return $this->createForm(
            $this->matchClassToFormTypeService->getTypeClass(
                $class,
                AbstractBicycleType::class
            ),
            $bicycle,
            $options
        );
    }
}