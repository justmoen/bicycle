<?php

namespace App\Tests\Service;

use App\Service\CalculateGearCombinationCountService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculateGearCombinationCountServiceTest extends KernelTestCase
{
    /**
     * @var CalculateGearCombinationCountService
     */
    private CalculateGearCombinationCountService $service;

    public function setUp(): void
    {
        $this->service = new CalculateGearCombinationCountService();
    }

    public function testCalculate()
    {
        $result = $this->service->calculate(2, 11);
        $this->assertEquals(22, $result);
    }
}