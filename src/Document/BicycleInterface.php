<?php

namespace App\Document;

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
     * @return array
     */
    function getComponents(): array;

    /**
     * @param array $components
     * @return BicycleInterface
     */
    function setComponents(array $components): BicycleInterface;

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
}