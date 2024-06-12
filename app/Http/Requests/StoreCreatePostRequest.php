<?php

namespace App\Http\Requests;

use App\Http\Requests\Common\PublicRequest;
use Carbon\Carbon;

class StoreCreatePostRequest extends PublicRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "post_id" => "required|numeric",
            "content" => "required|string",
            "media" => "array",
            "finished_at" => ["required", "date", function ($attribute, $value, $fail) {
                if (Carbon::parse($value)->isBefore(Carbon::now())) {
                    $fail(__('errors.validation.invalid_date'));
                }
            },]
        ];
    }

    public function messages()
    {
        return [
            "post_id" => __('errors.validation.required'),
            "post_id" => __('errors.validation.numbers'),

            "content" => __('errors.validation.required'),
            "content" => __('errors.validation.string'),

            "media" => __('errors.validation.array'),

            "finished_at" => __('errors.validation.required'),
            "finished_at" => __('errors.validation.date')
        ];
    }
}
