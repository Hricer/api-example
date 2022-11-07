<?php declare(strict_types=1);

namespace App\ArgumentResolver\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class Body
{
    public function __construct(private ?string $name = null)
    {
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
