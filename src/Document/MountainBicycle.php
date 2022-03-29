<?php

namespace App\Document;

use App\Document\Interface\BicycleInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class MountainBicycle extends Bicycle implements BicycleInterface
{
    /**
     * @var bool
     */
    private bool $hasRearSuspension;

    /**
     * @return string
     */
    public function getType(): string
    {
        return parent::BICYCLE_TYPE_MOUNTAIN;
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