<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;

class ServerErrorResponses extends Responses
{
    // HTTP Status Code 500
    public static function internalServerError($data = [])
    {
        return self::buildResponse($data, [], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
