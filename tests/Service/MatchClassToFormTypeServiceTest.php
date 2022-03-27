<?php

namespace App\Tests\Service;

use App\Service\ClassNameParserService;
use App\Service\MatchClassToFormTypeService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MatchClassToFormTypeServiceTest extends KernelTestCase
{
    /**
     * @var MatchClassToFormTypeService
     */
    private MatchClassToFormTypeService $service;

    public function setUp(): void
    {
        $this->service = new MatchClassToFormTypeService(
            new ClassNameParserService()
        );
    }

    public function testGetTypeClass()
    {
        $result = $this->service->getTypeClass('\document\ClassName', '\form\AbstractClassNameType');
        $this->assertEquals('\form\ClassNameType', $result);
    }
}