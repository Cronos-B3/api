<?php

namespace App\DTO\API\User;

use App\DTO\DTO;
use App\Models\User\UserEmail;

class UserEmailDTO extends DTO
{
    public string $fk_user_id;
    public string $email;
    public ?bool $primary;
    public ?string $status;

    public function __construct($data)
    {
        $this->fk_user_id = $data[UserEmail::PREFIX . 'fk_user_id'] ?? $data['fk_user_id'];
        $this->email = $data[UserEmail::PREFIX . 'email'];
        $this->primary = $data[UserEmail::PREFIX . 'primary'] ?? null;
        $this->status = $data[UserEmail::PREFIX . 'status'] ?? null;
    }
}