<?php

namespace App\Document;

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
}