<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\SuccessResponses;
use App\Logs\Logs;

class UpVoteController extends Controller
{
    //
    protected $user;
    protected $logs;
    //
    public function __construct()
    {
        $this->user = auth()->user();
        $this->logs = new Logs("UpVoteController");
    }

    public function store($cronId)
    {
        $funcName = 'store';
        $this->logs->info($funcName, 'Start', ['cron_id' => $cronId]);

        $cron = $this->user->crons()
            ->where('c_status', 'ACTIVE')
            ->where('c_id', $cronId)
            ->first();

        if (!$cron) {
            return ErrorResponses::notFound(['message' => 'Cron not found']);
        }

        $upVote = $this->user->upVotes()->where('uv_fk_cron_id', $cron->c_id)->first();

        if ($upVote) {
            $upVote->delete();
            return SuccessResponses::ok([], ['message' => "Up vote removed successfully"]);
        }
        $this->user->upVotes()->create(['uv_fk_cron_id' => $cron->c_id]);

        return SuccessResponses::created([], ['message' => "Up vote created successfully"]);
    }

    public function getCronUpVotes($cronId)
    {
        $funcName = 'getCronUpVotes';
        $this->logs->info($funcName, 'Start', ['cron_id' => $cronId]);

        $cron = $this->user->crons()
            ->where('c_status', 'ACTIVE')
            ->where('c_id', $cronId)
            ->first();


        if (!$cron) {
            return ErrorResponses::notFound(['message' => 'Cron not found']);
        }

        $upVotes = $cron->upVotes()->get();

        return SuccessResponses::ok(['up_votes' => $upVotes], ['message' => 'get up votes successfully']);
    }
}
