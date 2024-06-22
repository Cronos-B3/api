<?php

namespace App\Exceptions;

use Exception;

class AuthExceptions extends Exception
{
    public static function InvalidCredentials(): AuthExceptions
    {
        return new self("Invalid credentials", 400);
    }

    public static function UserNotFound(): AuthExceptions
    {
        return new self("User not found", 404);
    }

    public static function UserAlreadyExists(): AuthExceptions
    {
        return new self("User already exists", 400);
    }

    public static function UserNotConnected(): AuthExceptions
    {
        return new self("Unauthorized", 401);
    }

    public static function Unauthenticated(): AuthExceptions
    {
        return new self("Unauthenticated", 401);
    }
}
