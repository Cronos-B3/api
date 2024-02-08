<?php

namespace App\DTO\API\User;
use App\Models\User\User;

class UserAuthDTO extends UserDTO
{
    public string $password;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->password = $data[User::PREFIX . 'password'];
    }
}