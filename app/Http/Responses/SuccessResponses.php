<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;

class SuccessResponses extends Responses
{
    // HTTP Status Code 200
    public static function ok($data = [], array $metadata = [])
    {
        return self::buildResponse($data, $metadata, Response::HTTP_OK);
    }

    // HTTP Status Code 201
    public static function created($data = [], array $metadata = [])
    {
        return self::buildResponse($data, $metadata, Response::HTTP_CREATED);
    }

    // HTTP Status Code 204
    public static function noContent()
    {
        return self::buildResponse([], [], Response::HTTP_NO_CONTENT);
    }
}
