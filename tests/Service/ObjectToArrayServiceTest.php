<?php

namespace App\Tests\Service;

use App\Document\Component\FrontDerailleur;
use App\Document\RoadBicycle;
use App\Service\ObjectToArrayService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ObjectToArrayServiceTest extends KernelTestCase
{
    /**
     * @var ObjectToArrayService
     */
    private ObjectToArrayService $service;

    public function setUp(): void
    {
        $this->service = new ObjectToArrayService();
    }

    public function testConvert()
    {
        $roadBicycle = $this->createMock(RoadBicycle::class);
        $roadBicycle->method('getId')->willReturn('123');
        $roadBicycle->method('getName')->willReturn('name');
        $roadBicycle->method('getType')->willReturn('type');
        $roadBicycle->method('getComponents')->willReturn(new ArrayCollection([new FrontDerailleur()]));
        $result = $this->service->convert([
            0 => $roadBicycle
        ]);
        $this->assertEquals([
            0 => [
                'Id' => '123',
                'Type' => 'type',
                'Name' => 'name',
                'Price' => 0.0,
                'Weight' => 0.0
        ]], $result);
    }
}