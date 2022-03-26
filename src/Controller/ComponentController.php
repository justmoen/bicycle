<?php

namespace App\Controller;

use App\Document\ComponentInterface;
use App\Document\FrontDerailleur;
use App\Document\RearDerailleur;
use App\Form\AbstractComponentType;
use App\Form\SelectComponentType;
use App\Service\ComponentSetService;
use App\Service\MatchClassToFormTypeService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComponentController extends AbstractController
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
     * @param DocumentManager $documentManager
     * @param MatchClassToFormTypeService $matchClassToFormTypeService
     * @param ComponentSetService $componentSetService
     */
    public function __construct(
        DocumentManager $documentManager,
        MatchClassToFormTypeService $matchClassToFormTypeService,
        ComponentSetService $componentSetService
    ) {
        $this->documentManager = $documentManager;
        $this->matchClassToFormTypeService = $matchClassToFormTypeService;
        $this->componentSetService = $componentSetService;
    }

    #[Route('component/select', name: 'component_select', methods: ["GET"])]
    public function select(): Response
    {
        $form = $this->createForm(SelectComponentType::class);

        return $this->render('component/select.html.twig', [
            'form' => $form->createView(),
            'types' => [new FrontDerailleur(), new RearDerailleur()],
            'componentSets' => $this->componentSetService->getAll()
        ]);
    }

    #[Route('component/select', name: 'component_select_post', methods: ["POST"])]
    public function selectPost(Request $request): Response
    {
        $form = $this->createForm(SelectComponentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute(
                'component_create',
                ['class' => $form->get('componentType')->getData()]
            );
        }

        $this->addFlash('alert', 'Invalid entry');
        return $this->render('component/select.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('component/create/{class}', name: 'component_create', methods: ["GET"])]
    public function form(string $class): Response
    {
        $newClass = new $class;
        $form = $this->createForm(
            $this->matchClassToFormTypeService->getTypeClass(
                $class,
                AbstractComponentType::class
            ), $newClass
        );

        return $this->render('component/create.html.twig', [
            'form' => $form->createView(),
            'class' => $class,
            'componentType' => $newClass->getType()
        ]);
    }

    /**
     * @throws MongoDBException
     */
    #[Route('component/create/{class}', name: 'component_create_post', methods: ["POST"])]
    public function formPost(
        Request $request,
        string $class
    ): RedirectResponse {
        $newClass = new $class;
        $form = $this->createForm(
            $this->matchClassToFormTypeService->getTypeClass(
                $class,
                AbstractComponentType::class
            ), $newClass
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var ComponentInterface $component
             */
            $component = $form->getData();
            $component->setType($newClass->getType());
            $this->documentManager->persist($component);
            $this->documentManager->flush();
            return $this->redirectToRoute('component_select');
        }
        $this->addFlash('alert', 'Invalid entry');
        return $this->redirectToRoute('component_create');
    }
}