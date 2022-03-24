<?php

namespace App\Service;

use Doctrine\ODM\MongoDB\DocumentManager;

class AbstractCrudService implements CrudServiceInterface
{
    protected DocumentManager $documentManager;

    public function __construct(
        DocumentManager $documentManager
    ) {
        $this->documentManager = $documentManager;
    }

    function get(string $databaseName, string $collectionName, string $id): object|array|null
    {

        $db = $this->documentManager->getClient();
        $collection = $db->selectCollection($databaseName, $collectionName);
        return $collection->findOne($id);
    }

    function add(string $databaseName, string $collectionName, $data): object|array|null
    {
        $db = $this->documentManager->getClient();
        $collection = $db->selectCollection($databaseName, $collectionName);

        $result = $collection->insertOne($data);
        $id = $result->getInsertedId();
        return $this->get($databaseName, $collectionName, $id);
    }

    function update(string $databaseName, string $collectionName, $data, bool $replace = false)
    {
        // TODO: Implement update() method.
    }

    function delete(string $databaseName, string $collectionName, string $id)
    {
        // TODO: Implement delete() method.
    }
}