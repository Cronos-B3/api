<?php

namespace App\Repositories;

use App\Exceptions\ObjectExcpetions;
use App\Interfaces\GroupRepositoryInterface;
use App\Models\Group;

class GroupRepository implements GroupRepositoryInterface
{
    public function store($data)
    {
        $user = auth()->user();

        $data['creator_id'] = $user->id;

        $group = $user->groups()->create($data)
            ->load(['creator'])
            ->loadCount('users');

        return $group;
    }

    public function getMyGroups()
    {
        $user = auth()->user();

        $groups = $user->groups()
            ->with(['users', 'creator'])
            ->withCount('users')
            ->get();

        dd($groups);

        return $groups;
    }

    public function getGroupById($groupId)
    {
        $group = Group::with(['users', 'creator'])
            ->withCount('users')
            ->find($groupId);

        if (!$group) {
            throw ObjectExcpetions::InvalidGroup();
        }

        return $group;
    }

    public function update($data, $groupId)
    {
        $group = Group::find($groupId);

        if (!$group) {
            throw ObjectExcpetions::InvalidGroup();
        }

        $group->update($data);

        return $group;
    }

    public function delete($groupId)
    {
        $user = auth()->user();

        $group = Group::find($groupId);

        if (!$group) {
            throw ObjectExcpetions::InvalidGroup();
        }

        $isCreator = $group->creator_id === $user->id;

        if (!$isCreator) {
            throw ObjectExcpetions::NotAdmin();
        }
        $group->delete();
    }
}
