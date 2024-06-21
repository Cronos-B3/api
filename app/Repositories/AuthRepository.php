<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Models\User;
use Exception;

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
        $loginType = filter_var($data['idOrEmail'], FILTER_VALIDATE_EMAIL) ? 'email' : 'identifier';

        $user = User::firstWhere($loginType, $data['idOrEmail']);


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
