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
}