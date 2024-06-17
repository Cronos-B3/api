<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function index();
    public function store($data);
    public function getById($userId);
    public function update($data, $userId);
    public function delete($userId);
}
