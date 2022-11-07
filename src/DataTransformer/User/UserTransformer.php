<?php declare(strict_types=1);

namespace App\DataTransformer\User;

use App\DTO\User\UserDTO;
use App\Entity\User\User;

class UserTransformer implements DataTransformer
{
    public function toEntity(UserDTO $userDTO, User $user): User
    {
        $user->setFirstName($userDTO->firstName);
        $user->setLastName($userDTO->lastName);

        return $user;
    }

    public function toDTO(UserDTO $userDTO, User $user)
    {

    }
}
