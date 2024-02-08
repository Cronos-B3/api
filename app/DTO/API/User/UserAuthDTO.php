<?php

namespace App\DTO\API\User;

use App\Models\User\User;

class UserAuthDTO extends UserDTO
{
    public ?string $username;
    public ?string $nickname;
    public ?string $firstname;
    public ?string $lastname;
    public ?string $email;
    public ?string $phone;
    public ?string $birthdate;
    public ?string $password;

    public function __construct($data)
    {
        parent::__construct($data);

        $this->username = $data[User::PREFIX . 'username'] ?? $data['username'] ?? null;
        $this->nickname = $data[User::PREFIX . 'nickname'] ?? $data['nickname'] ?? null;
        $this->firstname = $data[User::PREFIX . 'firstname'] ?? $data['firstname'] ?? null;
        $this->lastname = $data[User::PREFIX . 'lastname'] ?? $data['lastname'] ?? null;
        $this->email = $data[User::PREFIX . 'email'] ?? $data['email'] ?? null;
        $this->phone = $data[User::PREFIX . 'phone'] ?? $data['phone'] ?? null;
        $this->birthdate = $data[User::PREFIX . 'birthdate'] ?? $data['birthdate'] ?? null;
        $this->password = $data[User::PREFIX . 'password'] ?? $data['password'] ?? null;
    }
}
