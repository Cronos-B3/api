<?php

namespace App\Http\Controllers\API\Auth;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\SuccessResponses;
use App\Logs\Logs;
use App\Models\User\User;
use App\Models\User\UserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    protected $logs;

    public function __construct()
    {
        $this->logs = new Logs("LoginController");
    }
    public function login(Request $request)
    {
        $funcName = 'login';
        $this->logs->info($funcName, 'Start', $request->all());

        $emailName = UserEmail::PREFIX . 'email';
        $passwordName = User::PREFIX . 'password';

        $credentials = $request->only($emailName, $passwordName);

        $userEmail = UserEmail::where($emailName, $credentials[$emailName])->where(UserEmail::PREFIX . 'status', Status::ACTIVE)->first();

        if (
            !$userEmail ||
            !Hash::check($credentials[$passwordName], $userEmail->user->u_password)
        ) {
            $this->logs->error($funcName, 'Invalid credentials');
            return ErrorResponses::unauthorized([], ['message' => 'Invalid credentials']);
        }

        $user = $userEmail->user;

        $token = auth()->login($user);

        $user->load('userEmails', 'userBalance', 'cards');

        $this->logs->info($funcName, 'User logged in successfully', ['user' => $user]);
        return SuccessResponses::ok(['token' => $token, 'user' => $user], ['message' => 'Login successful']);
    }

    public function Logout()
    {
        Log::info('LoginController :: Logout');

        auth()->logout();

        return SuccessResponses::ok([], ['message' => 'Logout successful']);
    }
}
