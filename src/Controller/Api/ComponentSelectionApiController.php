<?php

namespace App\Controller\Api;

use App\Document\Component\FrontDerailleur;
use App\Document\Component\RearDerailleur;
use App\Service\CalculateGearCombinationCountService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ComponentSelectionApiController extends AbstractController
{
    /**
     * @var CalculateGearCombinationCountService
     */
    private CalculateGearCombinationCountService $calculateGearCombinationCountService;

    /**
     * @param CalculateGearCombinationCountService $calculateGearCombinationCountService
     */
    public function __construct(
        CalculateGearCombinationCountService $calculateGearCombinationCountService
    ) {
        $this->calculateGearCombinationCountService = $calculateGearCombinationCountService;
    }

    /**
     * @return JsonResponse
     */
    #[Route('api/drivetrain/get-gear-combination-count')]
    public function getGearCombinationCount(): JsonResponse
    {
        $frontDerailleur = new FrontDerailleur();
        $frontDerailleur->setMaxCogCount(3);
        $rearDerailleur = new RearDerailleur();
        $rearDerailleur->setMaxCogCount(10);
        $numberOfGearCombinations = $this->calculateGearCombinationCountService->calculate(
            $frontDerailleur->getMaxCogCount(),
            $rearDerailleur->getMaxCogCount()
        );
        return new JsonResponse(["numberOfGearCombinations" => $numberOfGearCombinations]);
    }
}