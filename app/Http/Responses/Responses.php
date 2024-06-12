<?php

namespace App\Http\Responses;

abstract class Responses
{
    protected static function buildResponse($data, array $metadata, $status_code)
    {
        $metadata = array_merge($metadata, [
            'timestamp' => now()->toDateTimeString(),
            'ip' => request()->ip()
        ]);

        return response()->json([
            'data' => $data,
            'metadata' => $metadata
        ], $status_code);
    }
}
