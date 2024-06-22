<?php

namespace App\Http\Requests;

use App\Http\Requests\Common\PublicRequest;
use Carbon\Carbon;

class StorePostRequest extends PublicRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "content" => "required|string",
            "finished_at" => "required|date|after_or_equal:now",
        ];
    }

    public function messages()
    {
        return [
            'content.required' => __('errors.validation.required'),
            'content.string' => __('errors.validation.string'),

            'finished_at.required' => __('errors.validation.required'),
            'finished_at.date' => __('errors.validation.date'),
            'finished_at.after_or_equal' => __('errors.validation.invalid_date'),
        ];
    }
}
