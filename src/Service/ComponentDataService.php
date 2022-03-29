<?php

namespace App\Service;

use App\Document\Bicycle;
use App\Document\Component\AbstractComponent;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;

class ComponentDataService
{
    /**
     * @var DocumentManager
     */
    private DocumentManager $documentManager;

    /**
     * @param DocumentManager $documentManager
     */
    public function __construct(
        DocumentManager $documentManager
    ) {
        $this->documentManager = $documentManager;
    }

    /**
     * @param string $id
     * @throws LockException
     * @throws MappingException
     */
    public function delete(string $id)
    {
        $component = $this->documentManager->getRepository(AbstractComponent::class)->find($id);
        // @TODO not sure why this query does not work
        // $bicycles = $this->documentManager->getRepository(Bicycle::class)->findBy(['components.id' => $id]);
        $bicycles = $this->documentManager->getRepository(Bicycle::class)->findAll();
        foreach ($bicycles as $bicycle) {
            $bicycle->removeComponent($component);
        }
        $this->documentManager->remove($component);
    }
}