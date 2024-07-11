<?php

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    public function register($data);
    public function login($data);
    public function adminLogin($data);
}
