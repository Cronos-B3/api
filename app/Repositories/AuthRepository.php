<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\error;

class AuthRepository implements AuthRepositoryInterface
{
    public function register($data)
    {
        $userRepository = new UserRepository();
        $user = $userRepository->store($data);

        $token = auth()->login($user);

        return [
            'jwt' => $token,
            'user' => $user
        ];
    }

    public function login($data)
    {
        $loginType = filter_var($data['id_or_email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'identifier';

        $user = User::firstWhere($loginType, $data['id_or_email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new Exception('Invalid credentials', Response::HTTP_UNAUTHORIZED);
        }


        $token = auth()->login($user);

        return [
            'jwt' => $token,
            'user' => Auth::user()
        ];
    }
}
