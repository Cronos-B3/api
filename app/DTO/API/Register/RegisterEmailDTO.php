<?php

namespace App\DTO\API\Register;

use App\DTO\DTO;
use App\Models\User\User;

class RegisterEmailDTO extends DTO
{
    public string $email;

    public function __construct($data)
    {
        $this->email = $data[User::PREFIX . 'email'];
    }
}
