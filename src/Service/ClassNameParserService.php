<?php

namespace App\Service;

class ClassNameParserService
{
    /**
     * @param string $class
     * @return string|null
     */
    public function getClassName(string $class): ?string
    {
        $path = explode('\\', $class);
        return array_pop($path);
    }

    /**
     * @param string $className
     * @return string
     */
    public function getBaseName(string $className): string
    {
        return join("\\", array_slice(explode("\\", $className), 0, -1));
    }
}