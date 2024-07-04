<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCompleteResource;
use App\Interfaces\AuthRepositoryInterface;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    private AuthRepositoryInterface $authRepositoryInterface;

    public function __construct(AuthRepositoryInterface $authRepositoryInterface)
    {
        $this->authRepositoryInterface = $authRepositoryInterface;
    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $registerData = $this->authRepositoryInterface->register($data);
            DB::commit();
            return ApiResponseClass::sendSuccessResponse($registerData, 'User created successfully.', Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponseClass::sendErrorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $loginData = $this->authRepositoryInterface->login($credentials);
        return ApiResponseClass::sendSuccessResponse($loginData, 'User logged in successfully.', Response::HTTP_OK);
    }

    public function me()
    {
        $user = $this->authRepositoryInterface->me();
        return ApiResponseClass::sendSuccessResponse(new UserCompleteResource($user), 'User retrieved successfully.');
    }

    public function update(UpdateUserRequest $request)
    {
        DB::beginTransaction();
        try{
            $user = $this->authRepositoryInterface->update($request->validated());
            DB::commit();
            return ApiResponseClass::sendSuccessResponse(new UserCompleteResource($user), 'User updated successfully.');
        }catch (Exception $e) {
            DB::rollBack();
            return ApiResponseClass::sendErrorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try{
            $this->authRepositoryInterface->destroy();
            DB::commit();
            return ApiResponseClass::sendSuccessResponse([], 'User deleted successfully.', Response::HTTP_NO_CONTENT);
        }catch (Exception $e) {
            DB::rollBack();
            return ApiResponseClass::sendErrorResponse($e->getMessage(), $e->getCode());
        }
    }
}
