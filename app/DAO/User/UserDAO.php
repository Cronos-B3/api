<?php

namespace App\DAO\User;


use App\DTO\API\User\UserDTO;
use App\Models\User\User;

class UserDAO
{
    public function create(UserDTO $dto): User
    {
        $user = new User();
        $user->fill($dto->toArrayPrefixed(User::PREFIX));
        $user->save();

        return $user;
    }
    public function update(UserDTO $dto, User $user): User
    {
        $user->fill($dto->toArrayPrefixed(User::PREFIX));
        $user->save();

        return $user;
    }
}
