<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Common\PublicRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends PublicRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'identifier' => 'required|string|unique:users,identifier',
            'username' => 'string',
            'email' => 'required|string|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)->mixedCase()->letters()->numbers()
            ],
        ];
    }

    public function messages()
    {
        return [
            'identifier.required' => __('errors.validation.required'),
            'identifier.string' => __('errors.validation.string'),
            'identifier.unique' => __('errors.validation.unique'),

            'username.string' => __('errors.validation.string'),

            'email.required' => __('errors.validation.required'),
            'email.string' => __('errors.validation.string'),
            'email.email' => __('errors.validation.email'),
            'email.unique' => __('errors.validation.unique'),

            'password.required' => __('errors.validation.required'),
            'password.string' => __('errors.validation.string'),
            'password.confirmed' => __('errors.validation.confirmed'),
            'password.min' => __('errors.validation.min'),
            'password.mixedCase' => __('errors.validation.mixed_case'),
            'password.letters' => __('errors.validation.letters'),
            'password.numbers' => __('errors.validation.numbers'),
        ];
    }
}
