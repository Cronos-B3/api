<?php

namespace App\Interfaces;

interface GroupRepositoryInterface
{
    public function store($data);
    public function getMyGroups();
    public function getGroupById($groupId);
    public function update($data, $groupId);
    public function delete($groupId);
}
