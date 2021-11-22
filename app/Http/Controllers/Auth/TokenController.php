<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\FarazSMS;
use App\Models\User;
use App\Traits\ApiResponder;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class TokenController extends Controller
{
    use ApiResponder;

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users',
        ]);

        $token = rand(1001, 9999);
        Redis::set("token:{$request->phone}", $token, 'EX', intval(config('services.sms.expire')));

        if (config('app.debug') === true) {
            return $this->success(["token" => $token], "WARNING! THIS SHOULD ONLY BE USED IN DEBUG MODE.", 200);
        }

        $client = new FarazSMS(
            config('services.sms.farazsms.url'),
            config('services.sms.farazsms.key'),
            config('services.sms.farazsms.from'),
        );

        try {
            $response = $client->sendPattern(
                config('services.sms.farazsms.pattern'),
                $request->phone,
                [
                    "verification-code" => strval($token),
                ]
            );
            return $this->success($response, null, 200);

        } catch (TransferException $e) {
            if (config('app.env') !== 'production') {
                throw $e;
            } else return $this->failure("Can't send OTP code.", 503);
        }
    }

    public function update(Request $request, $phone)
    {
        $redisKey = "token:{$phone}";
        $token = Redis::get($redisKey);

        if ($token === $request->token) {
            Redis::del($redisKey);

            $user = User::where('phone', $phone)->first();
            Auth::login($user);
            $accessToken = $user->createToken('API Token')->plainTextToken;

            return $this->success(["user" => $user, "token" => $accessToken], "Logged in.", 200);
        } else {
            return $this->failure("The code is incorrect.", 406);
        }
    }
}
