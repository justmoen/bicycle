<?php

namespace App\Controller;

use App\Document\FrontDerailleur;
use App\Document\RearDerailleur;
use App\Service\CalculateGearCombinationCountService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ComponentSelectionController extends AbstractController
{
    private CalculateGearCombinationCountService $calculateGearCombinationCountService;

    public function __construct(
        CalculateGearCombinationCountService $calculateGearCombinationCountService
    ) {
        $this->calculateGearCombinationCountService = $calculateGearCombinationCountService;
    }

    #[Route('/drivetrain')]
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