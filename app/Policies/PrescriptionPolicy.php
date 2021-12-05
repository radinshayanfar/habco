<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrescriptionPolicy
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
        return $user->doctor?->patients->contains($patient);
    }

    public function sendToPharmacy(User $user, Prescription $prescription)
    {
        return $prescription->patient_id === $user->id;
    }

    public function setStatus(User $user, Prescription $prescription)
    {
        return $prescription->pharmacist_id === $user->id;
    }

    public function show(User $user, Prescription $prescription)
    {
        $id = $user->role . '_id';
        return $user->role === 'admin'
            || $prescription->$id === $user->id;
    }
}
