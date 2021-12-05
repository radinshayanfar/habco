<?php

namespace App\Policies;

use App\Models\Instruction;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstructionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function write(User $user, Patient $patient)
    {
        return $user->nurse?->patients->contains($patient);
    }

    public function show(User $user, Instruction $instruction)
    {
        $id = $user->role . '_id';
        return $user->role === 'admin'
            || $instruction->$id === $user->id;
    }
}
