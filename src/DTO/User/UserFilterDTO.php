<?php declare(strict_types=1);

namespace App\DTO\User;

class UserFilterDTO
{
    public ?string $search = null;
    public ?bool $active = null;
    public ?int $roleId = null;
    public ?\DateTime $createdFrom = null;
}
