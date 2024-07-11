<?php

namespace App\Http\Requests;

use App\Http\Requests\Common\PublicRequest;

class StoreGroupRequest extends PublicRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'description.string' => 'The description field must be a string.',
        ];
    }
}
