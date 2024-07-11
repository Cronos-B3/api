<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCompleteResource;
use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\PostRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    private AuthRepositoryInterface $authRepositoryInterface;
    private UserRepositoryInterface $userRepositoryInterface;
    private PostRepositoryInterface $postRepositoryInterface;

    public function __construct(AuthRepositoryInterface $authRepositoryInterface, UserRepositoryInterface $userRepositoryInterface, PostRepositoryInterface $postRepositoryInterface)
    {
        $this->authRepositoryInterface = $authRepositoryInterface;
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->postRepositoryInterface = $postRepositoryInterface;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $loginData = $this->authRepositoryInterface->adminLogin($credentials);
        return ApiResponseClass::sendSuccessResponse($loginData, 'User logged in successfully.', Response::HTTP_OK);
    }



    public function indexUser()
    {
        $users = $this->userRepositoryInterface->index();
        return ApiResponseClass::sendSuccessResponse(UserCompleteResource::collection($users), 'Users retrieved successfully.');
    }

    public function showUserById($userId)
    {
        $user = $this->userRepositoryInterface->getUserById($userId);
        return ApiResponseClass::sendSuccessResponse(new UserCompleteResource($user), 'User retrieved successfully.');
    }

    public function updateByUserId(UpdateUserRequest $request, $userId)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepositoryInterface->updateByUserId($request->validated(), $userId);
            DB::commit();
            return ApiResponseClass::sendSuccessResponse(new UserCompleteResource($user), 'User' . $userId . ' updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponseClass::sendErrorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function deleteUser($userId)
    {
        $this->userRepositoryInterface->destroyUser($userId);
        return ApiResponseClass::sendSuccessResponse([], 'User deleted successfully.', Response::HTTP_NO_CONTENT);
    }

    public function indexPost()
    {
        $posts = $this->postRepositoryInterface->index();
        return ApiResponseClass::sendSuccessResponse($posts, 'Posts retrieved successfully.');
    }

    public function showPostById($postId)
    {
        $post = $this->postRepositoryInterface->getById($postId);
        return ApiResponseClass::sendSuccessResponse($post, 'Post retrieved successfully.');
    }

    public function deletePost($postId)
    {
        $this->postRepositoryInterface->destroyPost($postId);
        return ApiResponseClass::sendSuccessResponse([], 'Post deleted successfully.', Response::HTTP_NO_CONTENT);
    }
}
