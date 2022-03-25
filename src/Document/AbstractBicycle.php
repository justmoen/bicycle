<?php

namespace App\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

abstract class AbstractBicycle implements BicycleInterface
{
    /**
     * @MongoDB\EmbedMany(targetDocument=ComponentInterface::class)
     */
    protected array $components = [];

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $type;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $name;

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
     * @return array
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * @param array $components
     * @return AbstractBicycle
     */
    public function setComponents(array $components): AbstractBicycle
    {
        $this->components = $components;
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
}