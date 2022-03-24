<?php

namespace App\Document;

use MongoDB\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

abstract class AbstractBicycle
{
    protected Collection $components;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $type;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $name;

    public function getComponents(): Collection
    {
        return $this->components;
    }

    public function setComponents(Collection $components): static
    {
        $this->components = $components;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }
}