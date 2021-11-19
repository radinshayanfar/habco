<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\FarazSMS;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users',
        ]);

        $token = rand(1001, 9999);
        Redis::set("token:{$request->phone}", $token, 'EX', intval(config('services.sms.expire')));

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
            return $response;

        } catch (TransferException $e) {
            if (config('app.env') != 'prduction') {
                throw $e;
            } else return response()->json(["message" => "Can't send OTP code."], 503);
        }
    }

    public function update(Request $request, $phone)
    {
        $redisKey = "token:{$phone}";
        $token = Redis::get($redisKey);

        if ($token === $request->token) {
            Redis::del($redisKey);
            return response()->json(["message" => "Ok"], 200);
        } else {
            return response()->json(["message" => "The code is incorrect."], 406);
        }
    }
}
