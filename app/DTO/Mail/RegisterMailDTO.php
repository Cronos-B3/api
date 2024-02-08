<?php

namespace App\DTO\Mail;

use App\DTO\DTO;

class RegisterMailDTO extends DTO
{
    public string $token;

    public function __construct($data)
    {
        $this->token = $data['token'];
    }
}