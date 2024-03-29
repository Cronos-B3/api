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

    const USERNAME_NAME = User::PREFIX . 'username';
    const USERNAME_DEFAULT = ['max:255', 'regex:/^[a-zA-Z0-9\s\-_]+$/'];
    const USERNAME_REGISTER_DEFAULT = ['max:255', 'regex:/^[a-zA-Z0-9\s\-_]+$/', 'unique:user,u_username'];
    const USERNAME_UPDTAE_DEFAULT = ['max:255', 'regex:/^[a-zA-Z0-9\s\-_]+$/', 'unique:user,u_username'];


    const NICKNAME_NAME = User::PREFIX . 'nickname';
    const NICKNAME_DEFAULT = ['max:255', 'regex:/^[a-zA-Z0-9\s\-_]+$/'];
    const NICKNAME_UPDTAE_DEFAULT = ['max:255', 'regex:/^[a-zA-Z0-9\s\-_]+$/', 'unique:user,u_nickname'];

    const EMAIL_NAME = User::PREFIX . 'email';
    const EMAIL_DEFAULT = [self::EMAIL];
    const EMAIL_REGISTER_DEFAULT = [self::EMAIL, 'unique:user,u_email'];


    const BIRTHDATE_NAME = User::PREFIX . 'birthdate';
    const BIRTHDATE_DEFAULT = ['date_format:Y-m-d'];





    // passwords rules
    const PASSWORD_NAME = User::PREFIX . 'password';


    const OLD_PASSWORD_NAME = User::PREFIX . 'old_password';
    const OLD_PASSWORD_DEFAULT = [];
    const PASSWORD_CONFIRMATION_NAME = User::PREFIX . 'password_confirmation';
    const PASSWORD_CONFIRMATION_DEFAULT = [];
}
