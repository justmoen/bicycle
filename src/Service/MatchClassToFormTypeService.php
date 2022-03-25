<?php

namespace App\Service;

class MatchClassToFormTypeService
{
    /**
     * @var ClassNameParserService
     */
    private ClassNameParserService $classNameParserService;

    /**
     * @param ClassNameParserService $classNameParserService
     */
    public function __construct(
        ClassNameParserService $classNameParserService
    ) {
        $this->classNameParserService = $classNameParserService;
    }

    /**
     * @param string $class
     * @param string $formTypeClass
     * @return string
     */
    public function getTypeClass(string $class, string $formTypeClass): string
    {
        return $this->classNameParserService->getBaseName($formTypeClass) .
            "\\" . $this->classNameParserService->getClassName($class) . 'Type';
    }
}