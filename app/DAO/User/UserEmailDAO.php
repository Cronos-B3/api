<?php

namespace App\DAO\User;

use App\DTO\API\User\UserEmailDTO;
use App\Models\User\UserEmail;

class UserEmailDAO
{
    public function create(UserEmailDTO $dto): UserEmail
    {
        $userEmail = new UserEmail();
        $userEmail->fill($dto->toArrayPrefixed(UserEmail::PREFIX));
        $userEmail->save();

        return $userEmail;
    }
}
