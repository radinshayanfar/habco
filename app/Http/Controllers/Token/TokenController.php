<?php

namespace App\Http\Controllers\Token;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class TokenController extends Controller
{
    use ApiResponder;

    public function store(Request $request)
    {
        $user = $request->user();

        $redisKey = "otp:{$user->phone}";
        $otp = Redis::get($redisKey);

        if ($otp === $request->otp) {
            Redis::del($redisKey);

            $appToken = $user->createAppToken()->plainTextToken;

            return $this->success(compact(["user", "appToken"]), "Logged in.", 201);
        } else {
            return $this->failure("The code is incorrect.", 406);
        }
    }

    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, "Logged out.", 200);
    }
}
