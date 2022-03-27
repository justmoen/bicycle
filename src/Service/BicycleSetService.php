<?php

namespace App\Service;

use App\Document\Abstract\AbstractBicycle;
use App\Document\ElectricBicycle;
use App\Document\MountainBicycle;
use App\Document\RoadBicycle;
use Doctrine\ODM\MongoDB\DocumentManager;

class BicycleSetService
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
     * @return array
     */
    public function getAll(): array
    {
        return [
            AbstractBicycle::BICYCLE_TYPE_ELECTRIC =>
                $this->objectToArrayService->convert(
                    $this->documentManager->getRepository(ElectricBicycle::class)->findAll()
                ),
            AbstractBicycle::BICYCLE_TYPE_ROAD =>
                $this->objectToArrayService->convert(
                    $this->documentManager->getRepository(RoadBicycle::class)->findAll()
                ),
            AbstractBicycle::BICYCLE_TYPE_MOUNTAIN =>
                $this->objectToArrayService->convert(
                    $this->documentManager->getRepository(MountainBicycle::class)->findAll()
                )
        ];
    }
}