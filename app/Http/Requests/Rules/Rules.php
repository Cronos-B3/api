<?php

namespace App\Http\Requests\Rules;

class Rules
{
    const REQUIRED = "required";
    const CONFIRMED = "confirmed";
    const NULLABLE = "nullable";
    const EXISTS = "exists";
    const EMAIL = 'email:rfc;dns';
    const PHONE = 'regex:^\+[1-9]\d{5,14}$^';
}
