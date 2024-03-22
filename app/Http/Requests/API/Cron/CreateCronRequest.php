<?php

namespace App\Http\Requests\API\Cron;

use App\Http\Requests\Common\PublicRequest;
use App\Http\Requests\Rules\Cron\CronRules;
use App\Http\Requests\Messages\Messages;
use App\Http\Requests\Rules\Rules;

class CreateCronRequest extends PublicRequest
{

    public function rules(): array
    {
        return [
            CronRules::TEXT => array_merge(CronRules::TEXT_DEFAULT, [Rules::REQUIRED]),
            CronRules::CHANEL => array_merge(CronRules::CHANEL_DEFAULT),
            CronRules::FK_CRON_ID => array_merge(CronRules::EMAIL_DEFAULT),
            CronRules::END_DATE => array_merge(CronRules::endDateRules(), [Rules::REQUIRED]),

        ];
    }

    public function messages()
    {
        return [
            CronRules::TEXT . '.required' => Messages::REQUIRED,
            CronRules::TEXT . '.max' => Messages::MAX,
            CronRules::TEXT . '.string' => Messages::FORMAT,

            CronRules::CHANEL . '.max' => Messages::MAX,
            CronRules::CHANEL . '.string' => Messages::FORMAT,

            CronRules::FK_CRON_ID . '.uuid' => Messages::FORMAT,
            CronRules::FK_CRON_ID . '.exists' => Messages::EXISTS,

            CronRules::END_DATE . '.required' => Messages::REQUIRED,
            CronRules::END_DATE . '.date_format' => Messages::FORMAT,
            CronRules::END_DATE . '.after_or_equal' => Messages::TIME,
        ];
    }
}
