<?php

namespace App\Repositories;

use App\Exceptions\AuthExceptions;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            throw AuthExceptions::InvalidCredentials();
        }

        $token = auth()->login($user);

        return [
            'jwt' => $token,
            'user' => Auth::user()
        ];
    }

    public function me()
    {
        $user = Auth::user();

        if (!$user) {
            throw AuthExceptions::Unauthenticated();
        }

        return $user;
    }
}
