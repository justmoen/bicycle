<?php

namespace App\Document\Component;

use App\Document\Interface\ComponentInterface;
use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document("Component")
 * @MongoDB\InheritanceType("SINGLE_COLLECTION")
 * @MongoDB\DiscriminatorField("type")
 * @MongoDB\DiscriminatorMap({
 *     AbstractComponent::COMPONENT_TYPE_FRONT_DERAILLEUR=FrontDerailleur::class,
 *     AbstractComponent::COMPONENT_TYPE_REAR_DERAILLEUR=RearDerailleur::class,
 *     })
 */
abstract class AbstractComponent implements ComponentInterface
{
    public const COMPONENT_TYPE_FRONT_DERAILLEUR = 'Front Derailleur';
    public const COMPONENT_TYPE_REAR_DERAILLEUR = 'Rear Derailleur';

    /**
     * @MongoDB\Id
     */
    protected string $id;

    /**
     * @MongoDB\Field(type="float")
     */
    protected float $price;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $name;

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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    abstract public function getType(): string;

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