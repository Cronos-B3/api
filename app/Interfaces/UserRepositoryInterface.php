<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function me();
    public function update($data);
    public function destroy();
    public function getUserById($userId);
}
