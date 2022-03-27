<?php

namespace App\Controller;

use App\Document\BicycleInterface;
use App\Document\ElectricBicycle;
use App\Document\FrontDerailleur;
use App\Document\MountainBicycle;
use App\Document\RearDerailleur;
use App\Document\RoadBicycle;
use App\Form\AbstractBicycleType;
use App\Form\BicycleType;
use App\Service\BicycleSetService;
use App\Service\ComponentSetService;
use App\Service\MatchClassToFormTypeService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Doctrine\ODM\MongoDB\MongoDBException;
use Doctrine\ODM\MongoDB\PersistentCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BicycleController extends AbstractController
{
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
     * @param DocumentManager $documentManager
     * @param MatchClassToFormTypeService $matchClassToFormTypeService
     * @param ComponentSetService $componentSetService
     * @param BicycleSetService $bicycleSetService
     */
    public function __construct(
        DocumentManager $documentManager,
        MatchClassToFormTypeService $matchClassToFormTypeService,
        ComponentSetService $componentSetService,
        BicycleSetService $bicycleSetService
    ) {
        $this->documentManager = $documentManager;
        $this->matchClassToFormTypeService = $matchClassToFormTypeService;
        $this->componentSetService = $componentSetService;
        $this->bicycleSetService = $bicycleSetService;
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
        $form = $this->createForm(
            $this->matchClassToFormTypeService->getTypeClass(
                $class,
                AbstractBicycleType::class
            ),
            $newClass,
            ['componentSets' => $this->componentSetService->getAll()]
        );

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
        $form = $this->createForm(
            $this->matchClassToFormTypeService->getTypeClass(
                $class,
                AbstractBicycleType::class
            ),
            $newClass,
            ['componentSets' => $this->componentSetService->getAll()]
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
            $bicycle->setType($newClass->getType());
            $bicycle
                ->addComponent($frontDerailleur)
                ->addComponent($rearDerailleur);
            $bicycle->setPrice($frontDerailleur->getPrice() + $rearDerailleur->getPrice());
            $bicycle->setWeight($frontDerailleur->getWeight() + $rearDerailleur->getWeight());
            $this->documentManager->persist($bicycle);
            $this->documentManager->flush();
            return $this->redirectToRoute('bicycle_select');
        }
        $this->addFlash('alert', 'Invalid entry');
        return $this->redirectToRoute('bicycle_build');
    }

    /**
     * @param string $type
     * @param string $id
     * @return Response
     * @throws LockException
     * @throws MappingException
     */
    #[Route('bicycle/edit/{type}/{id}', name: 'bicycle_edit', methods: ["GET"])]
    public function edit(string $type, string $id): Response
    {
        $class = '\\App\\Document\\' . $type . 'Bicycle';
        $bicycle = $this->documentManager->getRepository($class)->find($id);
        $form = $this->createForm(
            $this->matchClassToFormTypeService->getTypeClass(
                $class,
                AbstractBicycleType::class
            ),
            $bicycle,
            ['componentSets' => $this->componentSetService->getAll()]
        );

        return $this->render('bicycle/build.html.twig', [
            'form' => $form->createView(),
            'class' => $class,
            'bicycleType' => $bicycle->getType(),
            'bicycleSets' => $this->bicycleSetService->getAll()
        ]);
    }

    /**
     * @throws MappingException
     * @throws MongoDBException
     * @throws LockException
     */
    #[Route('bicycle/edit/{type}/{id}', name: 'bicycle_edit_post', methods: ["POST"])]
    public function editPost(Request $request, string $type, string $id): Response
    {
        $class = '\\App\\Document\\' . $type . 'Bicycle';
        $bicycle = $this->documentManager->getRepository($class)->find($id);
        $form = $this->createForm(
            $this->matchClassToFormTypeService->getTypeClass(
                $class,
                AbstractBicycleType::class
            ),
            $bicycle,
            ['componentSets' => $this->componentSetService->getAll()]
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->documentManager->flush();
            return $this->redirectToRoute('bicycle_select');
        }
        $this->addFlash('alert', 'Invalid entry');
        return $this->redirectToRoute('bicycle_edit');
    }

    /**
     * @throws MappingException
     * @throws LockException
     * @throws MongoDBException
     */
    #[Route('bicycle/delete/{type}/{id}', name: 'bicycle_delete', methods: ["GET"])]
    public function delete(string $type, string $id): RedirectResponse
    {
        $class = '\\App\\Document\\' . $type . 'Bicycle';
        $bicycle = $this->documentManager->getRepository($class)->find($id);
        $this->documentManager->remove($bicycle);
        $this->documentManager->flush();
        $this->addFlash('success', 'Bicycle successfully removed');
        return $this->redirectToRoute('bicycle_select');
    }
}