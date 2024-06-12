<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransformApiRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Transform keys of requests that are not GET to snake_case
        if ($request->method() !== 'GET') {
            $input = $request->all();
            $transformedInput = $this->transformKeysToSnakeCase($input);
            $request->replace($transformedInput);
        }

        return $next($request);
    }

    /**
     * Transform keys of an array to snake_case.
     *
     * @param  array  $input
     * @return array
     */
    private function transformKeysToSnakeCase($input)
    {
        $result = [];
        foreach ($input as $key => $value) {
            $snakeKey = Str::snake($key);
            $result[$snakeKey] = is_array($value) ? $this->transformKeysToSnakeCase($value) : $value;
        }
        return $result;
    }
}