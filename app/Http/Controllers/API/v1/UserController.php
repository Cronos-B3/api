<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\UpdateUserRequest;
use App\Http\Responses\SuccessResponses;
use App\Logs\Logs;
use Illuminate\Http\JsonResponse;

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
    protected $logs;


    public function __construct()
    {
        $this->user = auth()->user();
        $this->logs = new Logs("UserController");
    }

    public function getUsers(): JsonResponse
    {
        $funcName = 'getUsers';
        $this->logs->info($funcName, 'Start');

        $this->user->load('crons', 'crons.likes', 'crons.upVotes');
        return SuccessResponses::ok(['users' => $this->user], ['message' => 'Users']);
    }

    public function updateUser(UpdateUserRequest $request): JsonResponse
    {
        $funcName = 'updateUser';
        $this->logs->info($funcName, 'Start', $request->all());

        $this->user->update($request->validated());
        return SuccessResponses::ok(['user' => $this->user], ['message' => 'User updated']);
    }
}
