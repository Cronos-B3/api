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

        $emailField = User::PREFIX . 'email';
        $usernameField = User::PREFIX . 'username';
        $passwordField = User::PREFIX . 'password';

        $credentials = $request->only($emailField, $usernameField, $passwordField);
        $user = null;

        // Chercher l'utilisateur par e-mail ou nom d'utilisateur
        if (isset($credentials[$emailField])) {
            $user = User::where('u_email', $credentials[$emailField])->first();
        } elseif (isset($credentials[$usernameField])) {
            $user = User::where('u_username', $credentials[$usernameField])->first();
        }

        // Vérifier le mot de passe
        if (!$user || !Hash::check($credentials[$passwordField], $user->u_password)) {
            $this->logs->error($funcName, 'Invalid credentials');
            return ErrorResponses::unauthorized([], ['message' => 'Invalid credentials']);
        }

        // Générer le token
        $token = auth()->login($user);

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
