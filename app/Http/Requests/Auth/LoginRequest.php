<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Common\PublicRequest;

class LoginRequest extends PublicRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "id_or_email" => 'required|string',
            "password" => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'id_or_email.required' => __('errors.validation.required'),
            'id_or_email.string' => __('errors.validation.string'),

            'password.required' => __('errors.validation.required'),
            'password.string' => __('errors.validation.string')
        ];
    }
}
