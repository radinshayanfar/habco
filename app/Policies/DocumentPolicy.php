<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
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

    public function upload(User $user)
    {
        return in_array($user->role, ['doctor', 'nurse', 'pharmacist']);
    }

    public function verify(User $user)
    {
        return $user->role === 'admin';
    }

    public function show(User $user, Document $document)
    {
        $role = $user->role;
        return $user->role == 'admin'
            || $user->$role->document_id == $document->id
            || $user->$role->cv_id == $document->id;
    }
}
