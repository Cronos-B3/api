<?php

namespace App\Interfaces;

interface GroupUserRepositoryInterface
{
    public function join($groupId, $code);
    public function leave($groupId);
}
