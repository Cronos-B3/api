<?php

namespace App\Http\Requests\Rules\User;

use App\Http\Requests\Rules\Rules;
use App\Models\User\User;
use Illuminate\Validation\Rules\Password;

class UserRules extends Rules
{

    //methode static 
    //le regle est dynamique et ne peut pas être évalué au moment de la compilation) dans la déclaration d'une constante, ce qui n'est pas autorisé en PHP.
    public static function passwordRules()
    {
        return [
            Password::min(8)->letters()->mixedCase()->numbers(),
            'max:255'
        ];
    }

    const FIRSTNAME_NAME = User::PREFIX . 'firstname';
    const FIRSTNAME_DEFAULT = ['max:255', 'regex:/^[a-zA-Z\s\-_]+$/'];

    const LASTNAME_NAME = User::PREFIX . 'lastname';
    const LASTNAME_DEFAULT = ['max:255', 'regex:/^[a-zA-Z\s\-_]+$/'];

    const BIRTHDATE = User::PREFIX . 'birthdate';
    const BIRTHDATE_DEFAULT = ['date_format:Y-m-d'];


    // passwords rules
    const PASSWORD_NAME = User::PREFIX . 'password';
    const OLD_PASSWORD_NAME = User::PREFIX . 'old_password';
    const OLD_PASSWORD_DEFAULT = [];
    const PASSWORD_CONFIRMATION_NAME = User::PREFIX . 'password_confirmation';
    const PASSWORD_CONFIRMATION_DEFAULT = [];
}
