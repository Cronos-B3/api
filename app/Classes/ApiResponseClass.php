<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class ApiResponseClass
{
    public static function sendErrorResponse($e, $message = "Something went wrong! Process not completed", $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $response = [
            'message' => $e->getMessage() ?? $message,
            'data'    => [],
            'metadata' => [
                'timestamp' => now()->toDateTimeString(),
                'ip' => request()->ip()
            ]
        ];
        return response()->json($response, $e->getCode() ?? $code);
    }

    public static function sendSuccessResponse($result, $message = "Action completed", $code = Response::HTTP_OK)
    {
        $response = [
            'message' => $message,
            'data'    => $result,
            'metadata' => [
                'timestamp' => now()->toDateTimeString(),
                'ip' => request()->ip()
            ]
        ];
        return response()->json($response, $code);
    }
}
