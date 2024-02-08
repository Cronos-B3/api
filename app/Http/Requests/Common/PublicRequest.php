<?php

namespace App\Http\Requests\Common;

class PublicRequest extends FailedRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
