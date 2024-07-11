<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\JoinGroupRequest;
use App\Interfaces\GroupUserRepositoryInterface;
use Illuminate\Http\Request;

class GroupUserController extends Controller
{
    private GroupUserRepositoryInterface $groupUserRepositoryinterface;

    public function __construct(GroupUserRepositoryInterface $groupUserRepositoryinterface)
    {
        $this->groupUserRepositoryinterface = $groupUserRepositoryinterface;
    }

    public function store($groupId, $code)
    {
        $this->groupUserRepositoryinterface->join($groupId, $code);
        return ApiResponseClass::sendSuccessResponse([], 'Successfully joined the group');
    }

    public function delete($groupId)
    {
        $this->groupUserRepositoryinterface->leave($groupId);
        return ApiResponseClass::sendSuccessResponse([], 'Successfully left the group');
    }
}
