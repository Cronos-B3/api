<?php

namespace App\Http\Requests;

use App\Http\Requests\Common\PublicRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends PublicRequest
{
    public function rules(): array
    {
        return [
            'content' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => __('errors.validation.required'),
            'content.string' => __('errors.validation.string'),
        ];
    }
}
