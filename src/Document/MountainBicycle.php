<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** @MongoDB\Document */
class MountainBicycle extends AbstractBicycle implements BicycleInterface
{
    /**
     * @MongoDB\Id
     */
    private string $id;

    /**
     * @var bool
     */
    private bool $hasRearSuspension;

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
        return AbstractBicycle::BICYCLE_TYPE_MOUNTAIN;
    }

    /**
     * @return bool
     */
    public function isHasRearSuspension(): bool
    {
        return $this->hasRearSuspension;
    }

    /**
     * @param bool $hasRearSuspension
     * @return MountainBicycle
     */
    public function setHasRearSuspension(bool $hasRearSuspension): MountainBicycle
    {
        $this->hasRearSuspension = $hasRearSuspension;
        return $this;
    }
}