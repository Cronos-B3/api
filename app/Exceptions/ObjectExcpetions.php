<?php

namespace App\Exceptions;


class ObjectExcpetions extends CustomExceptions
{

    public static function InvalidPost(): ObjectExcpetions
    {
        return new self("Invalid post", 400);
    }
}
