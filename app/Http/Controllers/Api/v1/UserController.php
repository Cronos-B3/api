<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\OtherUserCompleteResource;
use App\Http\Resources\UserCompleteResource;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    private UserRepositoryInterface $userRepositoryInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }

    public function index()
    {
        $users = $this->userRepositoryInterface->index();
        return ApiResponseClass::sendSuccessResponse(UserCompleteResource::collection($users), 'Users retrieved successfully.');
    }

    public function me()
    {
        $user = $this->userRepositoryInterface->me();
        return ApiResponseClass::sendSuccessResponse(new UserCompleteResource($user), 'User retrieved successfully.');
    }

    public function showUserById($userId)
    {
        $user = $this->userRepositoryInterface->getUserById($userId);
        return ApiResponseClass::sendSuccessResponse(new OtherUserCompleteResource($user), 'User retrieved successfully.');
    }

    public function update(UpdateUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepositoryInterface->update($request->validated());
            DB::commit();
            return ApiResponseClass::sendSuccessResponse(new UserCompleteResource($user), 'User updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponseClass::sendErrorResponse($e->getMessage(), $e->getCode());
        }
    }

  

    public function deleteUser($userId)
    {
        DB::beginTransaction();
        try {
            $this->userRepositoryInterface->destroyUser($userId);
            DB::commit();
            return ApiResponseClass::sendSuccessResponse([], 'User' . $userId . ' deleted successfully.', Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponseClass::sendErrorResponse($e->getMessage(), $e->getCode());
        }
    }
}
