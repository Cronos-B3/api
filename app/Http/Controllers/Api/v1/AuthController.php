<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\ServerErrorResponses;
use App\Http\Responses\SuccessResponses;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::create($request->validated());

            $loginCredentials = [
                "email" => request("email"),
                "password" => request("password")
            ];

            if (!$token = auth()->attempt($loginCredentials)) {
                return ErrorResponses::unauthorized();
            }

            return SuccessResponses::created(["jwt" => $token, "user" => $user], ["message" => __("success.http_responses.auth.register")]);
        } catch (Exception $e) {
            return ServerErrorResponses::internalServerError(["message" => $e->getMessage()]);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->validated();

            $loginType = filter_var($credentials['id_or_email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'identifier';

            $loginCredentials = [
                $loginType => $credentials['id_or_email'],
                'password' => $credentials['password'],
            ];

            if (!$token = auth()->attempt($loginCredentials)) {
                return ErrorResponses::unauthorized(["message" => __('errors.auth.invalid_credentials')]);
            }
            return SuccessResponses::ok(["jwt" => $token, "user" => auth()->user()], ["message" => __('success.http_responses.auth.login')]);
        } catch (Exception $e) {
            return ServerErrorResponses::internalServerError(["message" => $e->getMessage()]);
        }
    }
}
