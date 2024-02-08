<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;

class ErrorResponses extends Responses
{
    // HTTP Status Code 401
    public static function unauthorized($data = [], array $metadata = [])
    {
        return self::buildResponse($data, $metadata, Response::HTTP_UNAUTHORIZED);
    }
    public static function unprocessable($data = [], array $metadata = [])
    {
        return self::buildResponse($data, $metadata, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    // HTTP Status Code 403
    public static function forbidden($data = [], array $metadata = [])
    {
        return self::buildResponse($data, $metadata, Response::HTTP_FORBIDDEN);
    }

    // HTTP Status Code 404
    public static function notFound($data = [], array $metadata = [])
    {
        return self::buildResponse($data, $metadata, Response::HTTP_NOT_FOUND);
    }

    // HTTP Status Code 425
    public static function tooEarly($data = [], array $metadata = [])
    {
        return self::buildResponse($data, $metadata, Response::HTTP_TOO_EARLY);
    }
}
