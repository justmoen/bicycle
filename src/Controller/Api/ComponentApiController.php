<?php

namespace App\Controller\Api;

use App\Document\AbstractComponent;
use App\Service\CrudServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ComponentApiController extends AbstractController
{
    private CrudServiceInterface $crudService;

    /**
     * @param CrudServiceInterface $crudService
     */
    public function __construct(
        CrudServiceInterface $crudService
    ) {
        $this->crudService = $crudService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('api/component/add', name: 'component_add', methods: ["POST"])]
    public function create(Request $request): JsonResponse
    {
        $component = json_decode($request->getContent(), true);
        // @TODO add validation
        $result = $this->crudService->add('Bicycle', AbstractComponent::COMPONENT_COLLECTION, $component);
        return new JsonResponse([
            'request' => [
                'method' =>'post',
                'content' => $request->getContent()
            ],
            'response'=> $result
        ]);
    }
}