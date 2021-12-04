<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\NurseResource;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Patient;
use App\Traits\ApiResponder;
use Illuminate\Contracts\Auth\Authenticatable;

class PatientController extends Controller
{
    use ApiResponder;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Authenticatable $user)
    {
        return $this->success($user->patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePatientRequest  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePatientRequest $request, Authenticatable $user)
    {
        $user->patient()->update($request->all());
        return $this->success($user->patient, 'Patient updated.');
    }

    public function generateHabcoId(Authenticatable $user)
    {

    }

    public function attachDoctor(Authenticatable $user, Doctor $doctor)
    {
        $user->patient->doctors()->attach($doctor->user_id);

        return $this->success(DoctorResource::collection($user->patient->doctors), 'Doctor added.');
    }

    public function attachNurse(Authenticatable $user, Nurse $nurse)
    {
        $user->patient->nurses()->attach($nurse->user_id);

        return $this->success(NurseResource::collection($user->patient->nurses), 'Nurse added.');
    }
}
