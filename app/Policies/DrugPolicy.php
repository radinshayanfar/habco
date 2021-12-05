<?php

namespace App\Policies;

use App\Models\Drug;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DrugPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can access the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function access(User $user, Drug $drug)
    {
        return $drug->pharmacist_id === $user->id;
    }
}
