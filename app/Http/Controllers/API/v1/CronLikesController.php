<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\SuccessResponses;
use App\Logs\Logs;
use Illuminate\Http\Request;
use Laravel\Telescope\Http\Controllers\LogController;

class CronLikesController extends Controller
{
    protected $user;
    protected $logs;
    //
    public function __construct()
    {
        $this->user = auth()->user();
        $$this->logs = new Logs("CronLikesController");
    }

    public function store($crondId)
    {
        $funcName = 'store';
        $this->logs->info($funcName, 'Start', ['cron_id' => $crondId]);

        $cron = $this->user->crons()
            ->where('c_status', 'ACTIVE')
            ->where('c_id', $crondId)
            ->first();

        if (!$cron) {
            return ErrorResponses::notFound(['message' => 'Cron not found']);
        }

        $like = $this->user->likes()->where('cl_fk_cron_id', $cron->c_id)->first();

        if ($like) {
            $like->delete();
            return SuccessResponses::ok([], ['message' => "Like removed successfully"]);
        }
        $this->user->likes()->create(['cl_fk_cron_id' => $cron->c_id]);

        return SuccessResponses::created([], ['message' => "Like created successfully"]);
    }

    public function getCronLikes($cronId)
    {
        $funcName = 'getCronLikes';
        $this->logs->info($funcName, 'Start', ['cron_id' => $cronId]);

        $cron = $this->user->crons()
            ->where('c_status', 'ACTIVE')
            ->where('c_id', $cronId)
            ->first();


        if (!$cron) {
            return ErrorResponses::notFound(['message' => 'Cron not found']);
        }

        $likes = $cron->likes()->get();

        return SuccessResponses::ok(['likes' => $likes], ['message' => 'get likes successfully']);
    }
}
