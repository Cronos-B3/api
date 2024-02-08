<?php

namespace App\Http\Controllers\API\v1\User;

use App\DAO\User\UserDAO;
use App\DTO\API\User\UserAuthDTO;
use App\DTO\API\User\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\UpdateUserRequest;
use App\Http\Requests\API\User\UpdateUserPasswordRequest;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\SuccessResponses;
use App\Mail\UpdatePasswordMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the user requests.
    |
    */
    protected $user;
    protected $userDAO;

    public function __construct(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
        $this->user = auth()->user();
    }

    // Will return all users only if the user is admin
    //TODO: Add middleware to check if the user is admin
    // public function index(): JsonResponse
    // {
    //     return SuccessResponses::ok(['users' => User::all()], ['message' => 'Users list']);
    // }

    public function updateUser(UpdateUserRequest $request): JsonResponse
    {
        $this->user = $this->userDAO->update(new UserDTO($request->all()), $this->user);
        return SuccessResponses::ok(['user' => $this->user], ['message' => 'User updated']);
    }
    public function updatePassword(UpdateUserPasswordRequest $request): JsonResponse
    {
        $passwords = $request->only('u_old_password', 'u_password');

        if (!Hash::check($passwords['u_old_password'], $this->user->u_password)) {
            return ErrorResponses::unprocessable([], ['message' => 'old password is incorrect']);
        }

        if (Hash::check($passwords['u_password'], $this->user->u_password)) {
            return ErrorResponses::unprocessable([], ['message' => 'new password is the same as the old password']);
        }

        $this->user = $this->userDAO->update(new UserAuthDTO($passwords), $this->user);



        $email = $this->user->u_email;

        if (!$email) {
            return ErrorResponses::unprocessable([], ['message' => 'User has no primary email']);
        }

        Mail::to($email)->queue(new UpdatePasswordMail());


        return SuccessResponses::ok(['user' => $this->user], ['message' => 'Password updated']);
    }
}
