<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        $cronId = $request->input('uv_fk_cron_id');

        $upVote = $this->user->upVotes()->where('uv_fk_cron_id', $cronId)->first();

        if ($upVote) {
            $upVote->delete();
            return SuccessResponses::ok([], ['message' => "Up vote removed successfully"]);
        }
        $this->user->upVotes()->create(['uv_fk_cron_id' => $cronId]);

        return SuccessResponses::created([], ['message' => "Up vote created successfully"]);
    }
}
