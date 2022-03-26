<?php

namespace App\Service;

use App\Document\AbstractComponent;
use App\Document\FrontDerailleur;
use App\Document\RearDerailleur;
use Doctrine\ODM\MongoDB\DocumentManager;

class ComponentSetService
{
    private DocumentManager $documentManager;

    /**
     * @param DocumentManager $documentManager
     */
    public function __construct(
        DocumentManager $documentManager
    ) {
        $this->documentManager = $documentManager;
    }

    /**
     * @return array
     */
   public function getAll(): array
    {
        return [
            AbstractComponent::COMPONENT_TYPE_FRONT_DERAILLEUR =>
                $this->toArray($this->documentManager->getRepository(FrontDerailleur::class)->findAll()),
            AbstractComponent::COMPONENT_TYPE_REAR_DERAILLEUR =>
                $this->toArray($this->documentManager->getRepository(RearDerailleur::class)->findAll())
        ];
    }

    /**
     * @param array $objectArray
     * @return array
     */
    public function toArray(array $objectArray): array
    {
        foreach ($objectArray as &$object) {
            $object = (array) $object;
        }
        return $objectArray;
    }
}