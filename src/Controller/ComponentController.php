<?php

namespace App\Controller;

use App\Document\Component\AbstractComponent;
use App\Document\Component\FrontDerailleur;
use App\Document\Component\RearDerailleur;
use App\Form\SelectComponentType;
use App\Service\ComponentDataService;
use App\Service\ComponentSetService;
use App\Service\MatchClassToFormTypeService;
use App\Traits\ComponentTrait;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Doctrine\ODM\MongoDB\MongoDBException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComponentController extends AbstractController
{
    use ComponentTrait;

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
     * @var ComponentDataService
     */
    private ComponentDataService $componentDataService;

    /**
     * @param DocumentManager $documentManager
     * @param MatchClassToFormTypeService $matchClassToFormTypeService
     * @param ComponentSetService $componentSetService
     * @param ComponentDataService $componentDataService
     */
    public function __construct(
        DocumentManager $documentManager,
        MatchClassToFormTypeService $matchClassToFormTypeService,
        ComponentSetService $componentSetService,
        ComponentDataService $componentDataService
    ) {
        $this->documentManager = $documentManager;
        $this->matchClassToFormTypeService = $matchClassToFormTypeService;
        $this->componentSetService = $componentSetService;
        $this->componentDataService = $componentDataService;
    }

    /**
     * @return Response
     */
    #[Route('component/select', name: 'component_select', methods: ["GET"])]
    public function select(): Response
    {
        $form = $this->createForm(SelectComponentType::class);
        return $this->render('component/select.html.twig', [
            'form' => $form->createView(),
            'types' => [new FrontDerailleur(), new RearDerailleur()],
            'componentSets' => $this->componentSetService->getAll(true)
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
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
            'form' => $form->createView(),
            'types' => [new FrontDerailleur(), new RearDerailleur()],
            'componentSets' => $this->componentSetService->getAll(true)
        ]);
    }

    /**
     * @param string $class
     * @return Response
     */
    #[Route('component/create/{class}', name: 'component_create', methods: ["GET"])]
    public function form(string $class): Response
    {
        $newClass = new $class;
        $form = $this->getForm($class, $newClass);
        return $this->render('component/create.html.twig', [
            'form' => $form->createView(),
            'class' => $class,
            'componentType' => $newClass->getType(),
            'componentSets' => $this->componentSetService->getAll(true)
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
        $form = $this->getForm($class, $newClass);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $component = $form->getData();
            $this->documentManager->persist($component);
            $this->documentManager->flush();
            return $this->redirectToRoute('component_select');
        }
        $this->addFlash('alert', 'Invalid entry');
        return $this->redirectToRoute('component_create');
    }

    /**
     * @param string $id
     * @return Response
     * @throws LockException
     * @throws MappingException
     */
    #[Route('component/edit/{id}', name: 'component_edit', methods: ["GET"])]
    public function edit(string $id): Response
    {
        $component = $this->documentManager->getRepository(AbstractComponent::class)->find($id);
        $class = get_class($component);
        $form = $this->getForm($class, $component);
        return $this->render('component/create.html.twig', [
            'form' => $form->createView(),
            'class' => $class,
            'componentType' => $component->getType(),
            'componentSets' => $this->componentSetService->getAll(true)
        ]);
    }

    /**
     * @throws MappingException
     * @throws MongoDBException
     * @throws LockException
     */
    #[Route('component/edit/{id}', name: 'component_edit_post', methods: ["POST"])]
    public function editPost(Request $request, string $id): Response
    {
        $component = $this->documentManager->getRepository(AbstractComponent::class)->find($id);
        $class = get_class($component);
        $form = $this->getForm($class, $component);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->documentManager->flush();
            return $this->redirectToRoute('component_select');
        }
        $this->addFlash('alert', 'Invalid entry');
        return $this->redirectToRoute('component_edit');
    }

    /**
     * @throws LockException
     * @throws MongoDBException
     * @throws MappingException
     */
    #[Route('component/delete/{id}', name: 'component_delete', methods: ["GET"])]
    public function delete(string $id): RedirectResponse
    {
        $this->componentDataService->delete($id);
        $this->documentManager->flush();
        $this->addFlash('success', 'Component successfully removed');
        return $this->redirectToRoute('component_select');
    }
}