<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;

class ErrorResponses extends Responses
{
    // HTTP Status Code 400
    public static function badRequest($data = [], array $metadata = [])
    {
        return self::buildResponse($data, $metadata, Response::HTTP_BAD_REQUEST);
    }

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

    // HTTP Status Code 405
    public static function methodeNotAllowed($data = [], array $metadata = [])
    {
        return self::buildResponse($data, $metadata, Response::HTTP_METHOD_NOT_ALLOWED);
    }

    // HTTP Status Code 409
    public static function conflict($data = [], array $metadata = [])
    {
        return self::buildResponse($data, $metadata, Response::HTTP_CONFLICT);
    }

    // HTTP Status Code 425
    public static function tooEarly($data = [], array $metadata = [])
    {
        return self::buildResponse($data, $metadata, Response::HTTP_TOO_EARLY);
    }
}
