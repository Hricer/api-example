<?php declare(strict_types=1);

namespace App\ArgumentResolver\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class Entity
{
    public function __construct(private ?string $property = null)
    {
    }

    public function getProperty(): ?string
    {
        return $this->property;
    }
}
