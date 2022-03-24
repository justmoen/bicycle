<?php

namespace App\Service;

interface CrudServiceInterface
{
    function get(string $databaseName, string $collectionName, string $id);

    function update(string $databaseName, string $collectionName, $data, bool $replace = false);

    function add(string $databaseName, string $collectionName, $data);

    function delete(string $databaseName, string $collectionName, string $id);
}