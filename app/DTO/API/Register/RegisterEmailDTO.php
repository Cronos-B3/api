<?php

namespace App\DTO\API\Register;

use App\DTO\DTO;
use App\Models\User\UserEmail;

class RegisterEmailDTO extends DTO
{
    public string $email;
    public int $scan;

    public function __construct($data)
    {
        $this->email = $data[UserEmail::PREFIX . 'email'];
    }
}
