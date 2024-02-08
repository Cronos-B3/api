<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\Common\PublicRequest;
use App\Http\Requests\Messages\Messages;
use App\Http\Requests\Rules\User\UserBalanceRules;
use App\Http\Requests\Rules\User\UserEmailRules;

class SendEmailRegisterRequest extends PublicRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            UserEmailRules::NAME => array_merge(UserEmailRules::DEFAULT , [UserEmailRules::REQUIRED, UserEmailRules::unique()]),
            UserBalanceRules::SCAN_NAME => array_merge(UserBalanceRules::SCAN_DEFAULT , [UserBalanceRules::NULLABLE, UserBalanceRules::MAX_10]),
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
            UserEmailRules::NAME . '.required' => Messages::REQUIRED,
            UserEmailRules::NAME . '.unique' => Messages::UNIQUE,
            UserEmailRules::NAME . '.email' => Messages::FORMAT,
            UserEmailRules::NAME . '.regex' => Messages::FORMAT,
            UserEmailRules::NAME . '.max' => Messages::FORMAT,

            UserBalanceRules::SCAN_NAME . '.int' => Messages::FORMAT,
            UserBalanceRules::SCAN_NAME . '.min' => Messages::FORMAT,
            UserBalanceRules::SCAN_NAME . '.max' => Messages::FORMAT,
        ];
    }
}
