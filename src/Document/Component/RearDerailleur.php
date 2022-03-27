<?php

namespace App\Document\Component;

use App\Document\Abstract\AbstractDerailleur;
use App\Document\Interface\ComponentInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class RearDerailleur extends AbstractDerailleur implements ComponentInterface
{
    /**
     * @MongoDB\Id
     */
    private string $id;

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
    public function getType(): string
    {
        return AbstractComponent::COMPONENT_TYPE_REAR_DERAILLEUR;
    }

    /**
     * @param string $type
     * @return RearDerailleur
     */
    public function setType(string $type): RearDerailleur
    {
        $this->type = $type;
        return $this;
    }
}