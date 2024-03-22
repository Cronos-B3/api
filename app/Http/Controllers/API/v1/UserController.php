<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\UpdateUserRequest;
use App\Http\Requests\API\User\UpdateUserPasswordRequest;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\SuccessResponses;
use App\Mail\UpdatePasswordMail;
use Illuminate\Http\JsonResponse;
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


    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function getUsers(): JsonResponse
    {
        $this->user->load('crons');
        return SuccessResponses::ok(['users' => $this->user], ['message' => 'Users']);
    }

    public function updateUser(UpdateUserRequest $request): JsonResponse
    {
        $this->user->update($request->validated());
        return SuccessResponses::ok(['user' => $this->user], ['message' => 'User updated']);
    }
    public function updatePassword(UpdateUserPasswordRequest $request): JsonResponse
    {
        if (!Hash::check($request->old_password, $this->user->u_password)) {
            return ErrorResponses::unauthorized(['message' => 'Old password is incorrect']);
        }

        $this->user->update(['u_password' => $request->new_password]);
        Mail::to($this->user->u_email)->send(new UpdatePasswordMail());
        return SuccessResponses::noContent();
    }
}
