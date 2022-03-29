<?php

namespace App\Controller;

use App\Document\Bicycle;
use App\Document\ElectricBicycle;
use App\Document\MountainBicycle;
use App\Document\RoadBicycle;
use App\Form\BicycleType;
use App\Service\BicycleDataService;
use App\Service\BicycleSetService;
use App\Service\ComponentSetService;
use App\Service\MatchClassToFormTypeService;
use App\Traits\BicycleTrait;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Doctrine\ODM\MongoDB\MongoDBException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BicycleController extends AbstractController
{
    use BicycleTrait;

    /**
     * @var MatchClassToFormTypeService
     */
    private MatchClassToFormTypeService $matchClassToFormTypeService;

    /**
     * @var DocumentManager
     */
    private DocumentManager $documentManager;

    /**
     * @var ComponentSetService
     */
    private ComponentSetService $componentSetService;

    /**
     * @var BicycleSetService
     */
    private BicycleSetService $bicycleSetService;

    /**
     * @var BicycleDataService
     */
    private BicycleDataService $bicycleDataService;

    /**
     * @param DocumentManager $documentManager
     * @param MatchClassToFormTypeService $matchClassToFormTypeService
     * @param ComponentSetService $componentSetService
     * @param BicycleSetService $bicycleSetService
     * @param BicycleDataService $bicycleDataService
     */
    public function __construct(
        DocumentManager $documentManager,
        MatchClassToFormTypeService $matchClassToFormTypeService,
        ComponentSetService $componentSetService,
        BicycleSetService $bicycleSetService,
        BicycleDataService $bicycleDataService
    ) {
        $this->documentManager = $documentManager;
        $this->matchClassToFormTypeService = $matchClassToFormTypeService;
        $this->componentSetService = $componentSetService;
        $this->bicycleSetService = $bicycleSetService;
        $this->bicycleDataService = $bicycleDataService;
    }

    /**
     * @return Response
     */
    #[Route('bicycle/select', name: 'bicycle_select', methods: ["GET"])]
    public function select(): Response
    {
        $form = $this->createForm(BicycleType::class);
        return $this->render('bicycle/select.html.twig', [
            'form' => $form->createView(),
            'types' => [new ElectricBicycle(), new MountainBicycle(), new RoadBicycle()],
            'bicycleSets' => $this->bicycleSetService->getAll()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('bicycle/select', name: 'bicycle_select_post', methods: ["POST"])]
    public function buildPost(Request $request): Response {
        $form = $this->createForm(BicycleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute(
                'bicycle_build',
                ['class' => $form->get('bicycleType')->getData()]
            );
        }

        $this->addFlash('alert', 'Invalid entry');
        return $this->render('bicycle/select.html.twig', [
            'form' => $form->createView(),
            'types' => [new ElectricBicycle(), new MountainBicycle(), new RoadBicycle()],
            'bicycleSets' => $this->bicycleSetService->getAll()
        ]);
    }

    /**
     * @param string $class
     * @return Response
     */
    #[Route('bicycle/build/{class}', name: 'bicycle_build', methods: ["GET"])]
    public function form(string $class): Response
    {
        $newClass = new $class;
        $form = $this->getForm($class, $newClass);
        return $this->render('bicycle/build.html.twig', [
            'form' => $form->createView(),
            'class' => $class,
            'bicycleType' => $newClass->getType(),
            'bicycleSets' => $this->bicycleSetService->getAll()
        ]);
    }

    /**
     * @throws MongoDBException
     */
    #[Route('bicycle/build/{class}', name: 'bicycle_build_post', methods: ["POST"])]
    public function formPost(
        Request $request,
        string $class
    ): RedirectResponse {
        $newClass = new $class;
        $form = $this->getForm($class, $newClass);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($bicycle = $this->bicycleDataService->processFormData(
                $form
            )) {
                $this->documentManager->persist($bicycle);
                $this->documentManager->flush();
                return $this->redirectToRoute('bicycle_select');
            }
            $this->addFlash('alert', 'Create Components First!');
            return $this->redirectToRoute('bicycle_build', [
                'class' => $class
            ]);
        }
        $this->addFlash('alert', 'Invalid entry');
        return $this->redirectToRoute('bicycle_build', [
            'class' => $class
        ]);
    }

    /**
     * @param string $id
     * @return Response
     * @throws LockException
     * @throws MappingException
     */
    #[Route('bicycle/edit/{id}', name: 'bicycle_edit', methods: ["GET"])]
    public function edit(string $id): Response
    {
        $bicycle = $this->documentManager->getRepository(Bicycle::class)->find($id);
        $class = get_class($bicycle);
        $form = $this->getForm($class, $bicycle);
        return $this->render('bicycle/build.html.twig', [
            'form' => $form->createView(),
            'class' => $class,
            'bicycleType' => $class,
            'bicycleSets' => $this->bicycleSetService->getAll()
        ]);
    }

    /**
     * @throws MappingException
     * @throws MongoDBException
     * @throws LockException
     */
    #[Route('bicycle/edit/{id}', name: 'bicycle_edit_post', methods: ["POST"])]
    public function editPost(Request $request, string $id): Response
    {
        $bicycle = $this->documentManager->getRepository(Bicycle::class)->find($id);
        $class = get_class($bicycle);
        $form = $this->getForm(
            $class,
            $bicycle
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->bicycleDataService->processFormData($form);
            $this->documentManager->flush();
            return $this->redirectToRoute('bicycle_select');
        }
        $this->addFlash('alert', 'Invalid entry');
        return $this->redirectToRoute('bicycle_edit', [
            'id' => $id
        ]);
    }

    /**
     * @throws MappingException
     * @throws LockException
     * @throws MongoDBException
     */
    #[Route('bicycle/delete/{id}', name: 'bicycle_delete', methods: ["GET"])]
    public function delete(string $id): RedirectResponse
    {
        $bicycle = $this->documentManager->getRepository(Bicycle::class)->find($id);
        $this->documentManager->remove($bicycle);
        $this->documentManager->flush();
        $this->addFlash('success', 'Bicycle successfully removed');
        return $this->redirectToRoute('bicycle_select', [
            'id' => $id
        ]);
    }
}