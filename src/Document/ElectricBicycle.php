<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class ElectricBicycle extends AbstractBicycle implements BicycleInterface
{
    /**
     * @MongoDB\Id
     */
    private string $id;

    /**
     * @MongoDB\Field(type="float")
     */
    private float $batteryCapacity;

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getBatteryCapacity(): float
    {
        return $this->batteryCapacity;
    }

    /**
     * @param float $batteryCapacity
     * @return ElectricBicycle
     */
    public function setBatteryCapacity(float $batteryCapacity): ElectricBicycle
    {
        $this->batteryCapacity = $batteryCapacity;
        return $this;
    }
}