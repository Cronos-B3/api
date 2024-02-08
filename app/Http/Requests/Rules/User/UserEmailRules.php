<?php

namespace App\Http\Requests\Rules\User;

use App\Enums\Status;
use App\Http\Requests\Rules\Rules;
use App\Models\User\UserEmail;
use Illuminate\Validation\Rule;

class UserEmailRules extends Rules
{
    const NAME = UserEmail::PREFIX . 'email';
    const DEFAULT = [self::EMAIL, "max:255"];

    public static function unique()
    {
        return Rule::unique('user_email', UserEmail::PREFIX . 'email')
            ->where(function ($query) {
                return $query->where(UserEmail::PREFIX . 'status', '!=', Status::DELETED);
            });
    }
}
