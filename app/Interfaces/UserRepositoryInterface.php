<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function index();
    public function me();
    public function getUserById($userId);
    public function update($data);
    public function destroy();
}
