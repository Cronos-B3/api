<?php

namespace App\DTO\API\User;

use App\DTO\DTO;
use App\Enums\Status;
use App\Models\User\User;

class UserDTO extends DTO
{
    public ?string $firstname;
    public ?string $lastname;
    public ?string $birthdate;

    public string $status = Status::ACTIVE;

    public function __construct($data)
    {
        $this->firstname = $data[User::PREFIX . 'firstname'] ?? null;
        $this->lastname = $data[User::PREFIX . 'lastname'] ?? null;
        $this->birthdate = $data[User::PREFIX . 'birthdate'] ?? null;
    }
}
