<?php

namespace App\Service;

use App\Document\Component\FrontDerailleur;
use App\Document\Component\RearDerailleur;
use App\Document\Interface\BicycleInterface;
use Symfony\Component\Form\FormInterface;

class BicycleDataService
{
    /**
     * @param FormInterface $form
     * @param BicycleInterface $mockBicycle
     * @return BicycleInterface|false
     */
    public function processFormData(
        FormInterface $form,
        BicycleInterface $mockBicycle
    ): bool|BicycleInterface {
        /**
         * @var BicycleInterface $bicycle
         */
        $bicycle = $form->getData();
        /**
         * @var FrontDerailleur $frontDerailleur
         */
        $frontDerailleur = $form->get('frontDerailleur')->getData();
        /**
         * @var RearDerailleur $rearDerailleur
         */
        $rearDerailleur = $form->get('rearDerailleur')->getData();
        $bicycle->setType($mockBicycle->getType());
        if (
            $frontDerailleur &&
            $rearDerailleur
        ) {
            $bicycle->removeAllComponents();
            $bicycle
                ->addComponent($frontDerailleur)
                ->addComponent($rearDerailleur);
            return $bicycle
                ->setPrice($frontDerailleur->getPrice() + $rearDerailleur->getPrice())
                ->setWeight($frontDerailleur->getWeight() + $rearDerailleur->getWeight());
        }
        return false;
    }
}