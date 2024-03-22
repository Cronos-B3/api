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
        $this->user->load('crons', 'crons.likes', 'crons.upVotes');
        return SuccessResponses::ok(['users' => $this->user], ['message' => 'Users']);
    }

    public function updateUser(UpdateUserRequest $request): JsonResponse
    {
        $this->user->update($request->validated());
        return SuccessResponses::ok(['user' => $this->user], ['message' => 'User updated']);
    }
}
