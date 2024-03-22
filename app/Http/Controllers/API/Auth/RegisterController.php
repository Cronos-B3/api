<?php

namespace App\Http\Controllers\API\Auth;



use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\StoreRegisterRequest;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\SuccessResponses;
use App\Logs\Logs;
use App\Mail\HelloMail;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    const CACHE_KEY = 'email_register_';
    protected $logs;

    public function __construct()
    {
        $this->logs = new Logs("RegisterController");
    }

    public function store(StoreRegisterRequest $request)
    {
        $funcName = 'store';
        $this->logs->info($funcName, 'Start', $request->all());

        $user = User::create($request->all());

        $token = auth()->login($user);
        Mail::to($request->u_email)->queue(new HelloMail());

        $this->logs->info($funcName, 'User successfully created', ['user' => $user]);
        return SuccessResponses::created(['token' => $token, 'user' => $user], ['message' => 'User successfully created']);
    }

    public function EmailExist(Request $request)
    {
        if (User::where('u_email', $request->input('u_email'))->exists()) {
            return ErrorResponses::conflict(['message' => 'Email already exists']);
        }
        return SuccessResponses::noContent();
    }
}
