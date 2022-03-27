<?php

namespace App\Controller\Api;

use App\Document\Component\FrontDerailleur;
use App\Document\Component\RearDerailleur;
use App\Service\CalculateGearCombinationCountService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ComponentSelectionApiController extends AbstractController
{
    /**
     * @var DocumentManager
     */
    private DocumentManager $documentManager;

    /**
     * @var CalculateGearCombinationCountService
     */
    private CalculateGearCombinationCountService $calculateGearCombinationCountService;

    /**
     * @param CalculateGearCombinationCountService $calculateGearCombinationCountService
     * @param DocumentManager $documentManager
     */
    public function __construct(
        CalculateGearCombinationCountService $calculateGearCombinationCountService,
        DocumentManager $documentManager
    ) {
        $this->calculateGearCombinationCountService = $calculateGearCombinationCountService;
        $this->documentManager = $documentManager;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws LockException
     * @throws MappingException
     */
    #[Route('api/drivetrain/get-max-gear-combination-count', name: 'get_max_gear_combination_count',  methods: ["POST"])]
    public function getMaxGearCombinationCount(Request $request): JsonResponse
    {
        $frontDerailleur = $this->documentManager
            ->getRepository(FrontDerailleur::class)->find($request->get('frontId'));
        $rearDerailleur = $this->documentManager
            ->getRepository(RearDerailleur::class)->find($request->get('rearId'));
        $numberOfGearCombinations = $this->calculateGearCombinationCountService->calculate(
            $frontDerailleur->getMaxCogCount(),
            $rearDerailleur->getMaxCogCount()
        );
        return new JsonResponse(["numberOfGearCombinations" => $numberOfGearCombinations]);
    }
}