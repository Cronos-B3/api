<?php

namespace App\Http\Requests\API\User;

use App\Http\Requests\Common\PublicRequest;
use App\Http\Requests\Rules\User\UserRules;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Messages\Messages;


class UpdateUserRequest extends PublicRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            UserRules::USERNAME_NAME => array_merge(UserRules::USERNAME_UPDTAE_DEFAULT),
            UserRules::NICKNAME_NAME => array_merge(UserRules::NICKNAME_UPDTAE_DEFAULT),
            UserRules::BIRTHDATE_NAME => array_merge(UserRules::BIRTHDATE_DEFAULT),
        ];
    }

    public function messages(): array
    {
        return [
            UserRules::USERNAME_NAME . '.max' => Messages::MAX,
            UserRules::USERNAME_NAME . '.regex' => Messages::FORMAT,
            UserRules::USERNAME_NAME . '.unique' => Messages::UNIQUE,

            UserRules::NICKNAME_NAME . '.max' => Messages::MAX,
            UserRules::NICKNAME_NAME . '.regex' => Messages::FORMAT,
            UserRules::NICKNAME_NAME . '.unique' => Messages::UNIQUE,

            UserRules::BIRTHDATE_NAME . '.date_format' => Messages::FORMAT,
        ];
    }
}
