<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\SuccessResponses;
use Illuminate\Http\Request;

class UpVoteController extends Controller
{
    //
    protected $user;
    //
    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function store($cronId)
    {
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
