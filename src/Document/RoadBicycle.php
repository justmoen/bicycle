<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** @MongoDB\Document */
class RoadBicycle extends AbstractBicycle implements BicycleInterface
{
    /**
     * @MongoDB\Id
     */
    private string $id;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return AbstractBicycle::BICYCLE_TYPE_ROAD;
    }
}