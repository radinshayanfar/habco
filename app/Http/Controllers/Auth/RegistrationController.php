<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    use ApiResponder;

    public function store(Request $request)
    {
        $request->validate([
            'email' => "required|email:rfc,dns",
            'phone' => "required|digits_between:8,20",
            'national_number' => "required|digits:10",
            'role' => "required|alpha",
        ]);

        $user = User::create(request(['email', 'phone', 'national_number', 'role']));

        return $this->success($user, "User created.", 200);
    }

}
