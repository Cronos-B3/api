<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\Common\PublicRequest;
use App\Http\Requests\Messages\Messages;
use App\Http\Requests\Rules\User\UserRules;

class StoreRegisterRequest extends PublicRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            UserRules::USERNAME_NAME => array_merge(UserRules::USERNAME_DEFAULT, [UserRules::REQUIRED]),
            UserRules::NICKNAME_NAME => array_merge(UserRules::NICKNAME_DEFAULT),

            UserRules::EMAIL_NAME => array_merge(UserRules::EMAIL_DEFAULT, [UserRules::REQUIRED]),
            UserRules::PHONE_NAME => array_merge(UserRules::PHONE_DEFAULT),

            UserRules::BIRTHDATE_NAME => array_merge(UserRules::BIRTHDATE_DEFAULT),

            UserRules::PASSWORD_NAME => array_merge(UserRules::passwordRules(), [UserRules::REQUIRED, UserRules::CONFIRMED]),
            UserRules::PASSWORD_CONFIRMATION_NAME => array_merge(UserRules::PASSWORD_CONFIRMATION_DEFAULT, [UserRules::REQUIRED]),

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * 
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            UserRules::USERNAME_NAME . '.required' => Messages::REQUIRED,
            UserRules::USERNAME_NAME . '.regex' => Messages::FORMAT,
            UserRules::USERNAME_NAME . '.max' => Messages::MAX,

            UserRules::NICKNAME_NAME . '.regex' => Messages::FORMAT,
            UserRules::NICKNAME_NAME . '.max' => Messages::MAX,

            UserRules::EMAIL_NAME . '.required' => Messages::REQUIRED,
            UserRules::EMAIL_NAME . '.email' => Messages::FORMAT,
            UserRules::EMAIL_NAME . '.unique' => Messages::UNIQUE,

            UserRules::PHONE_NAME . '.regex' => Messages::FORMAT,
            UserRules::PHONE_NAME . '.max' => Messages::MAX,

            UserRules::BIRTHDATE_NAME . '.date_format' => Messages::FORMAT,

            UserRules::PASSWORD_NAME . '.required' => Messages::REQUIRED,
            UserRules::PASSWORD_NAME . '.min' => Messages::FORMAT,
            UserRules::PASSWORD_NAME . '.letters' => Messages::FORMAT,
            UserRules::PASSWORD_NAME . '.mixed_case' => Messages::FORMAT,
            UserRules::PASSWORD_NAME . '.numbers' => Messages::FORMAT,
            UserRules::PASSWORD_NAME . '.max' => Messages::MAX,

            UserRules::PASSWORD_CONFIRMATION_NAME . '.required' => Messages::REQUIRED,
        ];
    }
}
