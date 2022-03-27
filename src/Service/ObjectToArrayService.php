<?php

namespace App\Service;

use ReflectionObject;

class ObjectToArrayService
{
    /**
     * @param array $objectArray
     * @return array
     */
    public function convert(array $objectArray): array
    {
        foreach ($objectArray as &$object) {
            $object = $this->getEntityPropertiesAsArray($object);
        }
        return $objectArray;
    }

    /**
     * @param $document
     * @param bool $strToLower
     * @return array
     */
    public function getEntityPropertiesAsArray(
        $document,
        bool $strToLower = false
    ): array {
        $oldReflection = new ReflectionObject($document);
        $return = array();
        foreach ($oldReflection->getMethods() as $method) {
            $name = $method->getName();
            if (str_starts_with($name, 'get')) {
                if (is_object($document->$name())) {
                    continue;
                }
                $propertyName = substr($name, 3);
                if ($strToLower) {
                    $return[strtolower($propertyName)] = $document->$name();
                } else {
                    $return[$propertyName] = $document->$name();
                }
            }
        }
        return $return;
    }
}