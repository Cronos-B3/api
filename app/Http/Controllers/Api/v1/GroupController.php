<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupCompleteResource;
use App\Http\Resources\GroupSoftResource;
use App\Interfaces\GroupRepositoryInterface;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    private GroupRepositoryInterface $groupRepositoryInterface;

    public function __construct(GroupRepositoryInterface $groupRepositoryInterface)
    {
        $this->groupRepositoryInterface = $groupRepositoryInterface;
    }

    public function store(StoreGroupRequest $request)
    {
        DB::beginTransaction();
        try {
            $group = $this->groupRepositoryInterface->store($request->validated());
            DB::commit();
            return ApiResponseClass::sendSuccessResponse($group, 'Group created successfully.', Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponseClass::sendErrorResponse('Group creation failed.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function showMyGroups()
    {
        $groups = $this->groupRepositoryInterface->getMyGroups();
        return ApiResponseClass::sendSuccessResponse(GroupSoftResource::collection($groups), 'Groups retrieved successfully.');
    }

    public function showById($groupId)
    {
        $group = $this->groupRepositoryInterface->getGroupById($groupId);
        return ApiResponseClass::sendSuccessResponse(new GroupCompleteResource($group), 'Group retrieved successfully.');
    }

    public function update(UpdateGroupRequest $request, $groupId)
    {
        DB::beginTransaction();
        try {
            $group = $this->groupRepositoryInterface->update($request->validated(), $groupId);
            DB::commit();
            return ApiResponseClass::sendSuccessResponse($group, 'Group updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponseClass::sendErrorResponse('Group update failed.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($groupId)
    {
        $this->groupRepositoryInterface->delete($groupId);
        return ApiResponseClass::sendSuccessResponse([], 'Group deleted successfully.', Response::HTTP_NO_CONTENT);
    }
}
