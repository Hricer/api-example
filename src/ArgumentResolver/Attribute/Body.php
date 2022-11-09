<?php declare(strict_types=1);

namespace App\ArgumentResolver\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class Body
{
    public function __construct(private ?string $format = null, private array $context = [], private bool $array = false)
    {
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function isArray(): bool
    {
        return $this->array;
    }
}
