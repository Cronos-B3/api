<?php

namespace App\Exceptions;


class ObjectExcpetions extends CustomExceptions
{

    public static function InvalidPost(): ObjectExcpetions
    {
        return new self("Invalid post", 400);
    }

    public static function InvalidUser(): ObjectExcpetions
    {
        return new self("Invalid user", 400);
    }

    public static function InvalidGroup(): ObjectExcpetions
    {
        return new self("Invalid group", 400);
    }

    public static function NotAdmin(): ObjectExcpetions
    {
        return new self("Not admin", 400);
    }

    public static function AlreadyFollowed(): ObjectExcpetions
    {
        return new self("Already followed", 400);
    }
}
