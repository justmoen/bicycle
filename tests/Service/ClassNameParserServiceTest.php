<?php

namespace App\Tests\Service;

use App\Service\CalculateGearCombinationCountService;
use App\Service\ClassNameParserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ClassNameParserServiceTest extends KernelTestCase
{
    /**
     * @var ClassNameParserService
     */
    private ClassNameParserService $service;

    public function setUp(): void
    {
        $this->service = new ClassNameParserService();
    }

    public function testGetClassName()
    {
        $result = $this->service->getClassName('\this\is\my\class');
        $this->assertEquals('class', $result);
    }

    public function testGetBaseName()
    {
        $result = $this->service->getBaseName('\this\is\my\class');
        $this->assertEquals('\this\is\my', $result);
    }
}