<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponder;

    public function show(Request $request)
    {
        return $this->success($request->user(), null, 200);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create(request(['email', 'phone', 'national_number', 'role']));

        return $this->success($user, "User created.", 201);
    }

    public function update(UpdateUserRequest $request)
    {
        $request->user()->update($request->all());
        return $this->success($request->user());
    }

}
