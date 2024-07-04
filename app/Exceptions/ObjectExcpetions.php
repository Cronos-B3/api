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

    public static function AlreadyFollowed(): ObjectExcpetions
    {
        return new self("Already followed", 400);
    }
}
