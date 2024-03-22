<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\API\Cron\CreateCronRequest;
use App\Http\Responses\SuccessResponses;

class CronController
{
    protected $user;
    public function __construct()
    {
        $this->user = auth()->user();
    }
    public function getCron()
    {
        $cron = $this->user->crons->where('c_status', 'ACTIVE');
        $cron->load('likes', 'upVotes');
        return SuccessResponses::ok(['crons' => $cron], ['message' => 'getCron']);
    }

    public function createCron(CreateCronRequest $request)
    {
        $cron = $this->user->crons()->create($request->validated());
        return SuccessResponses::created(["cron" => $cron], ['message' => 'cron created successfully']);
    }
}
