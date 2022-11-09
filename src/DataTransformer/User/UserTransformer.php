<?php declare(strict_types=1);

namespace App\DataTransformer\User;

use App\DTO\User\UserDTO;
use App\Entity\User\User;

class UserTransformer
{
    public function toEntity(UserDTO $userDTO, User $user): User
    {
        if ((new \ReflectionProperty($userDTO, 'firstName'))->isInitialized($userDTO)) {
            $user->setFirstName($userDTO->firstName);
        }

        if ((new \ReflectionProperty($userDTO, 'lastName'))->isInitialized($userDTO)) {
            $user->setLastName($userDTO->lastName);
        }

        if ((new \ReflectionProperty($userDTO, 'email'))->isInitialized($userDTO)) {
            $user->setEmail($userDTO->email);
        }

        return $user;
    }

    public function toDTO(UserDTO $userDTO, User $user)
    {

    }
}
