<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    use ApiResponder;

    public function show(Request $request)
    {
        return $this->success($request->user(), null, 200);
    }

    public function store(StoreUserRequest $request)
    {
        if (config('app.debug') !== true) {
            $request->validate([
                'role' => 'not_in:admin',
            ]);
        }

        try {
            $user = User::createWithRole($request);
        } catch (QueryException $ex) {
            $startWithField = Str::after($ex->getMessage(), 'UNIQUE constraint failed: users.');
            if (Str::startsWith($startWithField, ['email', 'national_number', 'phone'])) {
                $field = Str::before($startWithField, ' ');
                $fieldStr = preg_replace('/_/', ' ', $field);
                throw ValidationException::withMessages([
                     $field => "A user with this $fieldStr has been registered before.",
                ]);
            }
            throw $ex;
        }

        return $this->success($user, "User created.", 201);
    }

    public function update(UpdateUserRequest $request, Authenticatable $user)
    {
        $user->update($request->all());
        return $this->success($user);
    }

}
