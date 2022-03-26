<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

abstract class AbstractDerailleur extends AbstractComponent implements ComponentInterface
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

    /**
     * @return int
     */
    public function getMaxCogCount(): int
    {
        return $this->maxCogCount;
    }

    /**
     * @param int $maxCogCount
     * @return AbstractDerailleur
     */
    public function setMaxCogCount(int $maxCogCount): AbstractDerailleur
    {
        $this->maxCogCount = $maxCogCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinCogSize(): int
    {
        return $this->minCogSize;
    }

    /**
     * @param int $minCogSize
     * @return AbstractDerailleur
     */
    public function setMinCogSize(int $minCogSize): AbstractDerailleur
    {
        $this->minCogSize = $minCogSize;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxCogSize(): int
    {
        return $this->maxCogSize;
    }

    /**
     * @param int $maxCogSize
     * @return AbstractDerailleur
     */
    public function setMaxCogSize(int $maxCogSize): AbstractDerailleur
    {
        $this->maxCogSize = $maxCogSize;
        return $this;
    }
}