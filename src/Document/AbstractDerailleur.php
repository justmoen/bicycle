<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

abstract class AbstractDerailleur extends AbstractComponent
{
    /**
     * @MongoDB\Field(type="int")
     */
    protected int $maxCogCount;

    /**
     * @MongoDB\Field(type="int")
     */
    protected int $minCogSize;

    /**
     * @MongoDB\Field(type="int")
     */
    protected int $maxCogSize;

    public function getMaxCogCount(): int
    {
        return $this->maxCogCount;
    }

    public function setMaxCogCount(int $maxCogCount): static
    {
        $this->maxCogCount = $maxCogCount;
        return $this;
    }
}