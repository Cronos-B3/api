<?php

namespace App\Http\Requests\API\User;

use App\Http\Requests\Common\PublicRequest;
use App\Http\Requests\Rules\User\UserRules;
use App\Http\Requests\Messages\Messages;


class UpdateUserPasswordRequest extends PublicRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            UserRules::OLD_PASSWORD_NAME => array_merge(UserRules::OLD_PASSWORD_DEFAULT, [UserRules::REQUIRED]),
            UserRules::PASSWORD_NAME => array_merge(UserRules::passwordRules(), [UserRules::REQUIRED, UserRules::CONFIRMED]),
            UserRules::PASSWORD_CONFIRMATION_NAME => array_merge(UserRules::PASSWORD_CONFIRMATION_DEFAULT, [UserRules::REQUIRED]),
        ];
    }

    public function messages()
    {
        return [
            UserRules::OLD_PASSWORD_NAME . '.required' => Messages::REQUIRED,

            UserRules::PASSWORD_NAME . '.required' => Messages::REQUIRED,
            UserRules::PASSWORD_NAME . '.min' => Messages::MIN,
            UserRules::PASSWORD_NAME . '.max' => Messages::MAX,
            UserRules::PASSWORD_NAME . '.password.letters' => Messages::FORMAT,
            UserRules::PASSWORD_NAME . '.password.mixed_case' => Messages::FORMAT,
            UserRules::PASSWORD_NAME . '.password.numbers' => Messages::FORMAT,
            UserRules::PASSWORD_NAME . '.confirmed' => Messages::CONFIRMED,

            UserRules::PASSWORD_CONFIRMATION_NAME . '.required' => Messages::REQUIRED,
        ];
    }
}
