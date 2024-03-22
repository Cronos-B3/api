<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\API\Cron\CreateCronRequest;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\SuccessResponses;
use App\Logs\Logs;

class CronController
{
    protected $user;
    protected $logs;
    public function __construct()
    {
        $this->user = auth()->user();
        $this->logs = new Logs("CronController");
    }
    public function getCrons()
    {
        $funcName = 'getCrons';
        $this->logs->info($funcName, 'Start');

        $currentDateTime = now();

        $expiredCrons = $this->user->crons()
            ->where('c_status', 'ACTIVE')
            ->where('c_end_at', '<', $currentDateTime)
            ->get();

        foreach ($expiredCrons as $cron) {
            $cron->delete();
        }

        $crons = $this->user->crons()
            ->where('c_status', 'ACTIVE')
            ->get()
            ->loadCount(['likes', 'upVotes', 'comments']);

        if ($crons->isEmpty()) return ErrorResponses::notFound(['message' => 'No crons found']);

        return SuccessResponses::ok(['crons' => $crons], ['message' => 'getCrons']);
    }

    public function getCron($cronId)
    {
        $funcName = 'getCron';
        $this->logs->info($funcName, 'Start', ['cron_id' => $cronId]);

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

    public function createCron(CreateCronRequest $request)
    {
        $funcName = 'createCron';
        $this->logs->info($funcName, 'Start', $request->all());

        $data = $request->validated();

        if (isset($data['c_fk_cron_id'])) {
            $parentCron = $this->user->crons()
                ->where('c_id', $request->input('c_fk_cron_id'))
                ->first();

            if ($parentCron) {
                $data['c_end_at'] = $parentCron->c_end_at;
            } else {
                return ErrorResponses::notFound(['message' => 'Parent cron not found']);
            }
        }

        $cron = $this->user->crons()->create($data);
        return SuccessResponses::created(["cron" => $cron], ['message' => 'cron created successfully']);
    }
}
