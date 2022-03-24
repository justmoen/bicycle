<?php

namespace App\Document;

use MongoDB\Collection;

interface BicycleInterface
{
    function getComponents(): Collection;

    function setComponents(Collection $components): static;

    function getType(): string;

    function setType(string $type): static;

    function getName(): string;

    function setName(string $name): static;
}