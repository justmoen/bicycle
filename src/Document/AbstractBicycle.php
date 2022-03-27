<?php

namespace App\Document;

use App\Document\Interface\BicycleInterface;
use App\Document\Interface\ComponentInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

abstract class AbstractBicycle implements BicycleInterface
{
    public const BICYCLE_TYPE_ELECTRIC = 'Electric';
    public const BICYCLE_TYPE_ROAD = 'Road';
    public const BICYCLE_TYPE_MOUNTAIN = 'Mountain';

    /**
     * @MongoDB\ReferenceMany()
     */
    protected Collection $components;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $type;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $name;

    /**
     * @MongoDB\Field(type="float")
     */
    protected float $price;

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

    public function __construct()
    {
        $this->components = new ArrayCollection();
    }

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
     * @return Collection
     */
    public function getComponents(): Collection
    {
        return $this->components;
    }

    /**
     * @param ComponentInterface $component
     * @return AbstractBicycle
     */
    public function addComponent(ComponentInterface $component): AbstractBicycle
    {
        $this->components[] = $component;
        return $this;
    }

    /**
     * @param ComponentInterface $component
     * @return AbstractBicycle
     */
    public function removeComponent(ComponentInterface $component): AbstractBicycle
    {
        $this->components->removeElement($component);
        return $this;
    }

    /**
     * @return AbstractBicycle
     */
    public function removeAllComponents(): AbstractBicycle
    {
        foreach ($this->components as $component) {
            $this->components->removeElement($component);
        }
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
     * @return AbstractBicycle
     */
    public function setType(string $type): AbstractBicycle
    {
        $this->type = $type;
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
     * @return AbstractBicycle
     */
    public function setName(string $name): AbstractBicycle
    {
        $this->name = $name;
        return $this;
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
     * @return AbstractBicycle
     */
    public function setPrice(float $price): AbstractBicycle
    {
        $this->price = $price;
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
     * @return AbstractBicycle
     */
    public function setWeight(float $weight): AbstractBicycle
    {
        $this->weight = $weight;
        return $this;
    }
}