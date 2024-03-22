<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\API\Cron\CreateCronRequest;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\SuccessResponses;

class CronController
{
    protected $user;
    public function __construct()
    {
        $this->user = auth()->user();
    }
    public function getCrons()
    {
        $crons = $this->user->crons()
            ->where('c_status', 'ACTIVE')
            ->get()
            ->loadCount(['likes', 'upVotes', 'comments']);

        if (!$crons) return ErrorResponses::notFound(['message' => 'No crons found']);

        return SuccessResponses::ok(['crons' => $crons], ['message' => 'getCron']);
    }

    public function createCron(CreateCronRequest $request)
    {
        $cron = $this->user->crons()->create($request->validated());
        return SuccessResponses::created(["cron" => $cron], ['message' => 'cron created successfully']);
    }

    public function getCron($cronId)
    {
        $cron = $this->user->crons()
            ->with(['comments'])
            ->where('c_status', 'ACTIVE')
            ->where('c_id', $cronId)
            ->first();

        if (!$cron) {
            return ErrorResponses::notFound(['message' => 'Cron not found']);
        }

        $cron->loadCount(['likes', 'upVotes']);

        foreach ($cron->comments as $comment) {
            $comment->loadCount(['likes', 'upVotes', 'comments']);
        }

        return SuccessResponses::ok(['crons' => $cron], ['message' => 'get cron by id']);
    }
}
