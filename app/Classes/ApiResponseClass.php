<?php

namespace App\Classes;

use Illuminate\Http\Response;

class ApiResponseClass
{
    public static function sendErrorResponse($message = "Something went wrong! Process not completed", $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $response = [
            'message' => $message,
            'data'    => [],
            'metadata' => [
                'timestamp' => now()->toDateTimeString(),
                'ip' => request()->ip()
            ]
        ];
        return response()->json($response, $code);
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
