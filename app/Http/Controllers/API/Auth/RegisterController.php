<?php

namespace App\Http\Controllers\API\Auth;



use App\DAO\User\UserDAO;


use App\DTO\API\Register\RegisterEmailDTO;
use App\DTO\API\User\UserAuthDTO;
use App\DTO\Mail\RegisterMailDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\SendEmailRegisterRequest;
use App\Http\Requests\API\Auth\StoreRegisterRequest;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\SuccessResponses;
use App\Logs\Logs;
use App\Mail\RegisterMail;
use App\Mail\HelloMail;
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
    protected $logs;

    public function __construct(
        UserDAO $userDAO,
    ) {
        $this->userDAO = $userDAO;
        $this->logs = new Logs("RegisterController");
    }

    // Will finish the creation of the user
    public function store(StoreRegisterRequest $request)
    {
        $funcName = 'store';
        $this->logs->info($funcName, 'Start', $request->all());

        $user = DB::transaction(function () use ($request) {

            $datas = $request->all();

            $userDTO = new UserAuthDTO($datas);

            $user = $this->userDAO->create($userDTO);

            return $user;
        });

        $token = auth()->login($user);
        Mail::to($request->u_email)->queue(new HelloMail());

        $this->logs->info($funcName, 'User successfully created', ['user' => $user]);
        return SuccessResponses::created(['token' => $token, 'user' => $user], ['message' => 'User successfully created']);
    }
}
