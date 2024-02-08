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
            UserRules::FIRSTNAME_NAME => array_merge(UserRules::FIRSTNAME_DEFAULT),
            UserRules::LASTNAME_NAME => array_merge(UserRules::LASTNAME_DEFAULT),
            UserRules::BIRTHDATE => array_merge(UserRules::BIRTHDATE_DEFAULT),
        ];
    }

    public function messages(): array
    {
        return [
            UserRules::FIRSTNAME_NAME . '.regex' => Messages::FORMAT,
            UserRules::FIRSTNAME_NAME . '.min' => Messages::MIN,
            UserRules::FIRSTNAME_NAME . '.max' => Messages::MAX,

            UserRules::LASTNAME_NAME . '.regex' => Messages::FORMAT,
            UserRules::LASTNAME_NAME . '.min' => Messages::MIN,
            UserRules::LASTNAME_NAME . '.max' =>   Messages::MAX,

            UserRules::BIRTHDATE . '.date_format' => Messages::FORMAT,
        ];
    }
}
