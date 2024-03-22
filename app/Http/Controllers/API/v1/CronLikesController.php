<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponses;
use Illuminate\Http\Request;

class CronLikesController extends Controller
{
    protected $user;
    //
    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function store(Request $request)
    {
        $cronId = $request->input('cl_fk_cron_id');

        $like = $this->user->likes()->where('cl_fk_cron_id', $cronId)->first();

        if ($like) {
            $like->delete();
            return SuccessResponses::ok([], ['message' => "Like removed successfully"]);
        }
        $this->user->likes()->create(['cl_fk_cron_id' => $cronId]);

        return SuccessResponses::created([], ['message' => "Like created successfully"]);
    }
}
