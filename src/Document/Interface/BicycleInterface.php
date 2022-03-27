<?php

namespace App\Document\Interface;

use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

interface BicycleInterface
{
    /**
     * @return string
     */
    function getId(): string;

    /**
     * @MongoDB\PrePersist
     */
    public function onPrePersist();

    /**
     * @MongoDB\PreUpdate
     */
    public function onPreUpdate();

    /**
     * @return Collection
     */
    function getComponents(): Collection;

    /**
     * @param ComponentInterface $component
     * @return BicycleInterface
     */
    function addComponent(ComponentInterface $component): BicycleInterface;

    /**
     * @param ComponentInterface $component
     * @return BicycleInterface
     */
    function removeComponent(ComponentInterface $component): BicycleInterface;

    /**
     * @return string
     */
    function getType(): string;

    /**
     * @param string $type
     * @return BicycleInterface
     */
    function setType(string $type): BicycleInterface;

    /**
     * @return string
     */
    function getName(): string;

    /**
     * @param string $name
     * @return BicycleInterface
     */
    function setName(string $name): BicycleInterface;

    /**
     * @return float
     */
    public function getPrice(): float;

    /**
     * @param float $price
     * @return BicycleInterface
     */
    public function setPrice(float $price): BicycleInterface;

    /**
     * @return float
     */
    public function getWeight(): float;

    /**
     * @param float $weight
     * @return BicycleInterface
     */
    public function setWeight(float $weight): BicycleInterface;
}