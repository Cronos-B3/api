<?php

namespace App\Repositories;

use App\Exceptions\ObjectExcpetions;
use App\Interfaces\GroupUserRepositoryInterface;
use App\Models\Group;

class GroupUserRepository implements GroupUserRepositoryInterface
{
    public function join($groupId, $code)
    {
        $user = auth()->user();

        $group = Group::find($groupId);

        if (!$group || $group->code !== $code) {
            throw ObjectExcpetions::InvalidGroup();
        }

        if (!$user->groups()->where('group_id', $groupId)->exists()) {
            $user->groups()->attach($groupId);
        }
    }

    public function leave($groupId)
    {
        $user = auth()->user();

        $group = Group::find($groupId);

        if (!$group) {
            throw ObjectExcpetions::InvalidGroup();
        }

        $user->groups()->detach($groupId);
    }
}
