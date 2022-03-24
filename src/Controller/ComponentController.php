<?php

namespace App\Controller;

use App\Document\AbstractComponent;
use App\Service\CrudServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ComponentController extends AbstractController
{
    private CrudServiceInterface $crudService;

    public function __construct(CrudServiceInterface $crudService) {
        $this->crudService = $crudService;
    }

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