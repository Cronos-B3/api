<?php

namespace App\Logs;

use Illuminate\Support\Facades\Log;

class Logs
{
    protected $keyFiltered = [];
    protected $controller = "";
    protected $ip = "";
    protected $userId = "";

    public function __construct(string $controller = "", array $keyFiltered = [])
    {
        $this->controller = $controller;
        $this->ip = request()->ip() ?? "";
        $this->userId = auth()->user() ? auth()->user()->id : "";
        $this->keyFiltered = array_merge(['token', 'password'], $keyFiltered);
    }

    public static function crash($message, $file, $line)
    {
        Log::error("INTERNAL SERVER ERROR\n\tMessage: {$message}\n\tFile: {$file}\n\tLine: {$line}");
    }

    private function formatLog(string $function = "SET_A_FUNCTION", string $message = "SET_A_MESSAGE", array $data = [])
    {
        $data = array_filter($data, function ($key) {
            return !in_array($key, $this->keyFiltered);
        }, ARRAY_FILTER_USE_KEY);

        $log = "\n\tController: {$this->controller}::{$function}\n\tIP: {$this->ip}";
        if ($this->userId) {
            $log .= "\n\tUser ID: {$this->userId}";
        }

        $log .= "\n\tMessage: {$message}";

        if ($data != []) {
            $log .= "\n\tData: " . json_encode($data);
        }

        return $log . "\n";
    }

    public function error(string $function, string $error, array $data = [])
    {
        Log::error($this->formatLog($function, $error, $data));
    }

    public function info(string $function, string $message, array $data = [])
    {
        Log::info($this->formatLog($function, $message, $data));
    }
}