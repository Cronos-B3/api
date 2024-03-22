<?php

namespace App\Http\Requests\Rules\Cron;

use App\Http\Requests\Rules\Rules;
use App\Models\Cron;
use Carbon\Carbon;

class CronRules extends Rules
{
    public static function endDateRules()
    {
        return [
            'date_format:Y-m-d H:i:s',
            'after_or_equal:' . Carbon::now(),
        ];
    }
    const TEXT = Cron::PREFIX . 'text';
    const TEXT_DEFAULT = ['max:255', "string"];


    const CHANEL = Cron::PREFIX . 'chanel';
    const CHANEL_DEFAULT = ['max:255', "string"];

    const FK_CRON_ID = Cron::PREFIX . 'fk_cron_id';
    const EMAIL_DEFAULT = ["uuid", "exists:cron,c_id"];

    const END_DATE = Cron::PREFIX . 'end_at';
    // const END_DATE_DEFAULT = 
}
