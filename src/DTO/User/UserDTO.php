<?php declare(strict_types=1);

namespace App\DTO\User;

use Symfony\Component\Validator\Constraints as Asset;

class UserDTO
{
    public int $id;

    #[Asset\NotBlank]
    #[Asset\Email]
    public ?string $email;

    #[Asset\NotBlank]
    public ?string $firstName;

    #[Asset\NotBlank]
    public string $lastName;
    public string $pw;
}
