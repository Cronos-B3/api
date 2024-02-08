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
        return [];
    }

    /**
     * Get the error messages for the defined validation rules.
     * 
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [];
    }
}
