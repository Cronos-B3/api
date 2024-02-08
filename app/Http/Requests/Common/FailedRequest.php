<?php

namespace App\Http\Requests\Common;

use App\Http\Responses\ErrorResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class FailedRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        Log::error('Failed validation', ['errors' => $validator->getMessageBag()->toArray()]);
        throw new HttpResponseException(
            ErrorResponses::unprocessable($validator->getMessageBag()->toArray(), ['message' => 'Validation error'])
        );
    }
}
