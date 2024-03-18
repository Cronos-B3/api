<?php

namespace App\Http\Controllers\API\v1;

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
        return SuccessResponses::ok(['crons' => $cron], ['message' => 'getCron']);
    }

    public function createCron()
    {
        $cron = $this->user->crons()->create([
            'c_fk_user_id' => $this->user->u_id,
            'c_text' => 'Test',
            'c_chanel' => 'Test',
            'c_end_at' => now()->addMinutes(5),
        ]);

        return SuccessResponses::ok(["cron" => $cron], ['message' => 'createCron']);
    }
}
