<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\SuccessResponses;
use App\Logs\Logs;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    protected $user;
    protected $logs;
    public function __construct()
    {
        $this->user = auth()->user();
        $this->logs = new Logs("CommentsController");
    }

    public function index($crondId)
    {
        $funcName = 'index';
        $this->logs->info($funcName, 'Start', ['cron_id' => $crondId]);

        $cron = $this->user->crons()
            ->where('c_status', 'ACTIVE')
            ->where('c_id', $crondId)
            ->first();

        if (!$cron) {
            return ErrorResponses::notFound(['message' => 'Cron not found']);
        }


        $comments = $cron->comments()
            ->where('c_status', 'ACTIVE')
            ->where('c_fk_cron_id', $crondId)
            ->get();

        return SuccessResponses::ok(['comments' => $comments], ['message' => 'get comments successfully']);
    }
}
