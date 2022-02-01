<?php

namespace App\Http\Controllers\Token;

use App\Http\Controllers\Controller;
use App\Http\FarazSMS;
use App\Models\User;
use App\Traits\ApiResponder;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class LoginTokenController extends Controller
{
    use ApiResponder;

    public function store(Request $request)
    {
        // Finding user by phone
        try {
            $user = User::findByPhoneOrFail($request->phone);
        } catch (ModelNotFoundException) {
            return $this->failure('No user is registered with this phone number.', 404);
        }

        // Creating random OTP
        $otp = rand(1001, 9999);
        Redis::set("otp:{$user->phone}", $otp, 'EX', intval(config('services.sms.expire')));

        // Sending OTP either via SMS or http (DEBUG ONLY)
        if (config('app.debug') === true) {
            $loginToken = $user->createLoginToken()->plainTextToken;
            return $this->success(compact(["otp", "loginToken"]), "WARNING! THIS IS ONLY FOR DEBUGGING PURPOSES.\nToken={$otp}", 200);
        }

        $client = new FarazSMS(
            config('services.sms.farazsms.url'),
            config('services.sms.farazsms.key'),
            config('services.sms.farazsms.from'),
        );

        try {
            $response = $client->sendPattern(
                config('services.sms.farazsms.pattern'),
                $user->phone,
                [
                    "verification-code" => strval($otp),
                ]
            );

            // Issuing login token
            $loginToken = $user->createLoginToken()->plainTextToken;

            return $this->success(compact(["loginToken"]), "Code has been sent to your number.", 200);

        } catch (TransferException $e) {
            if (config('app.env') !== 'production') {
                throw $e;
            } else return $this->failure("Can't send OTP code.", 503);
        }
    }
}
