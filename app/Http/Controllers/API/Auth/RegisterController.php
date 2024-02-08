<?php

namespace App\Http\Controllers\API\Auth;

use App\DAO\Card\CardDAO;
use App\DAO\User\UserBalanceDAO;
use App\DAO\User\UserDAO;
use App\DAO\User\UserEmailDAO;
use App\DTO\API\Card\CardDTO;
use App\DTO\API\Register\RegisterEmailDTO;
use App\DTO\API\User\UserAuthDTO;
use App\DTO\API\User\UserBalanceDTO;
use App\DTO\API\User\UserEmailDTO;
use App\DTO\Mail\RegisterMailDTO;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\SendEmailRegisterRequest;
use App\Http\Requests\API\Auth\StoreRegisterRequest;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\SuccessResponses;
use App\Logs\Logs;
use App\Mail\RegisterMail;
use App\Mail\HelloMail;
use App\Models\Card\Card;
use App\Models\User\UserBalance;
use App\Models\User\UserEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    const CACHE_KEY = 'email_register_';
    protected $userDAO;
    protected $userEmailDAO;
    protected $cardDAO;
    protected $userBalanceDAO;
    protected $logs;

    public function __construct(
        UserDAO $userDAO,
        UserEmailDAO $userEmailDAO,
        UserBalanceDAO $userBalanceDAO,
        CardDAO $cardDAO,
    ) {
        $this->userDAO = $userDAO;
        $this->userEmailDAO = $userEmailDAO;
        $this->userBalanceDAO = $userBalanceDAO;
        $this->cardDAO = $cardDAO;
        $this->logs = new Logs("RegisterController");
    }

    // Will send the email to the user and store datas in cache
    public function sendEmail(SendEmailRegisterRequest $request)
    {
        $funcName = 'sendEmail';
        $this->logs->info($funcName, 'Start', $request->all());

        $registerEmailDTO = new RegisterEmailDTO($request->all());

        $lastSendMin = 300; // 5 minutes
        $token = Str::random(50);
        $cacheKey = self::CACHE_KEY . $registerEmailDTO->email;
        $ttl = 86400; // 1 day

        if (Cache::has($cacheKey)) {
            [$oldToken, $lastSentAt] = Cache::get($cacheKey);

            $lastSend = Carbon::now()->diffInSeconds($lastSentAt);

            if ($lastSend < $lastSendMin) {
                $remainingTime = ['remainingTime' => $lastSendMin - $lastSend];
                $this->logs->error($funcName, 'Too early to send email', $remainingTime);
                return ErrorResponses::tooEarly($remainingTime, ['message' => 'Too early to send email']);
            }
            Cache::forget($oldToken);
        }

        $registerMailDTO = new RegisterMailDTO(['token' => $token]);
        Mail::to($registerEmailDTO->email)->queue(new RegisterMail($registerMailDTO));

        Cache::put($cacheKey, [$token, now()], $ttl);
        Cache::put($token, $registerEmailDTO, $ttl);

        $this->logs->info($funcName, 'Email sent successfully');
        return SuccessResponses::noContent();
    }

    private function isTokenValid($token)
    {
        if (!Cache::has($token)) {
            return false;
        }

        $registerEmailDTO = Cache::get($token);
        $cacheKey = self::CACHE_KEY . $registerEmailDTO->email;

        return Cache::has($cacheKey);
    }

    // Will verify that the token is to create an account
    public function verifyToken(Request $request)
    {
        $funcName = 'verifyToken';
        $this->logs->info($funcName, 'Start', $request->all());

        if (!(isset($request->token) && self::isTokenValid($request->token))) {
            $this->logs->error($funcName, 'Token not found');
            return ErrorResponses::notFound([], ['message' => 'Token not found']);
        }

        $this->logs->info($funcName, 'Token successfully verified');
        return SuccessResponses::noContent();
    }

    // Will finish the creation of the user
    public function store(StoreRegisterRequest $request)
    {
        $funcName = 'store';
        $this->logs->info($funcName, 'Start', $request->all());

        if (!(isset($request->token) && self::isTokenValid($request->token))) {
            $this->logs->error($funcName, 'Token not found');
            return ErrorResponses::notFound([], ['message' => 'Token not found']);
        }

        $user = DB::transaction(function () use ($request) {
            $registerEmailDTO = Cache::get($request->token);

            $userDTO = new UserAuthDTO($request->all());
            $user = $this->userDAO->create($userDTO);

            $request->merge([
                'fk_user_id' => $user->u_id,

                UserEmail::PREFIX . 'email' => $registerEmailDTO->email,
                UserEmail::PREFIX . 'primary' => true,
                UserEmail::PREFIX . 'status' => Status::ACTIVE,

                UserBalance::PREFIX . 'scan' => $registerEmailDTO->scan,
            ]);

            $userEmailDTO = new UserEmailDTO($request->all());
            $userEmail = $this->userEmailDAO->create($userEmailDTO);

            $userBalanceDTO = new UserBalanceDTO($request->all());
            $this->userBalanceDAO->create($userBalanceDTO);

            $request->merge([
                Card::PREFIX . 'firstname' => explode("@", $userEmail->ue_email)[0],
                Card::PREFIX . 'email' => $userEmail->ue_email,
                Card::PREFIX . 'status' => Status::ACTIVE,
            ]);

            $cardDTO = new CardDTO($request->all());
            $cardDTO->formatSlug(true);
            $cardDTO->formatTitle();
            $this->cardDAO->create($cardDTO);

            Cache::forget($request->token);
            $cacheKey = self::CACHE_KEY . $registerEmailDTO->email;
            Cache::forget($cacheKey);

            return $user;
        })->load('userEmails', 'userBalance', 'cards');

        $token = auth()->login($user);
        Mail::to($request->ue_email)->queue(new HelloMail());

        $this->logs->info($funcName, 'User successfully created', ['user' => $user]);
        return SuccessResponses::created(['token' => $token, 'user' => $user], ['message' => 'User successfully created']);
    }
}
