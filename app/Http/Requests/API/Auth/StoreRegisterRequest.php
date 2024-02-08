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
            UserRules::PASSWORD_NAME => array_merge(UserRules::passwordRules(), [UserRules::REQUIRED]),
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
            UserRules::PASSWORD_NAME . '.required' => Messages::REQUIRED,
            UserRules::PASSWORD_NAME . '.min' => Messages::FORMAT,
            UserRules::PASSWORD_NAME . '.max' => Messages::FORMAT,
            UserRules::PASSWORD_NAME . '.password.letters' => Messages::FORMAT,
            UserRules::PASSWORD_NAME . '.password.mixed_case' => Messages::FORMAT,
            UserRules::PASSWORD_NAME . '.password.numbers' => Messages::FORMAT,
            UserRules::PASSWORD_NAME . '.confirmed' => Messages::CONFIRMED,
        ];
    }
}
