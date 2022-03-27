<?php

namespace App\Document\Component;

use App\Document\Interface\ComponentInterface;
use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

abstract class AbstractComponent implements ComponentInterface
{
    public const COMPONENT_COLLECTION = 'Component';
    public const COMPONENT_TYPE_FRONT_DERAILLEUR = 'Front Derailleur';
    public const COMPONENT_TYPE_REAR_DERAILLEUR = 'Rear Derailleur';

    /**
     * @MongoDB\Field(type="float")
     */
    protected float $price;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $type;

    /**
     * @MongoDB\Field(type="float")
     */
    protected float $weight;

    /**
     * @var DateTime
     */
    protected DateTime $createdAt;

    /**
     * @var DateTime
     */
    protected DateTime $updatedAt;

    /**
     * @MongoDB\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @MongoDB\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new DateTime();
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return AbstractComponent
     */
    public function setPrice(float $price): AbstractComponent
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return AbstractComponent
     */
    public function setName(string $name): AbstractComponent
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return AbstractComponent
     */
    public function setType(string $type): AbstractComponent
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @return AbstractComponent
     */
    public function setWeight(float $weight): AbstractComponent
    {
        $this->weight = $weight;
        return $this;
    }
}