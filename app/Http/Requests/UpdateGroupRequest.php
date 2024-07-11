<?php

namespace App\Http\Requests;

use App\Http\Requests\Common\PublicRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends PublicRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'The name field must be a string.',
            'description.string' => 'The description field must be a string.',
        ];
    }
}
