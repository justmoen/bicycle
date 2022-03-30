<?php

namespace App\Service;

use App\Document\Component\Component;
use App\Document\Component\FrontDerailleur;
use App\Document\Component\RearDerailleur;
use Doctrine\ODM\MongoDB\DocumentManager;

class ComponentSetService
{
    /**
     * @var DocumentManager
     */
    private DocumentManager $documentManager;

    /**
     * @var ObjectToArrayService
     */
    private ObjectToArrayService $objectToArrayService;

    /**
     * @param DocumentManager $documentManager
     * @param ObjectToArrayService $objectToArrayService
     */
    public function __construct(
        DocumentManager $documentManager,
        ObjectToArrayService $objectToArrayService
    ) {
        $this->documentManager = $documentManager;
        $this->objectToArrayService = $objectToArrayService;
    }

    /**
     * @param bool $toArray
     * @return array
     */
   public function getAll(bool $toArray = false): array
    {
        $frontDerailleurs = $this->documentManager->getRepository(FrontDerailleur::class)->findAll();
        $rearDerailleurs = $this->documentManager->getRepository(RearDerailleur::class)->findAll();
        return [
            Component::COMPONENT_TYPE_FRONT_DERAILLEUR =>
                $toArray ? $this->objectToArrayService->convert($frontDerailleurs) : $frontDerailleurs,
            Component::COMPONENT_TYPE_REAR_DERAILLEUR =>
                $toArray ? $this->objectToArrayService->convert($rearDerailleurs) : $rearDerailleurs
        ];
    }
}