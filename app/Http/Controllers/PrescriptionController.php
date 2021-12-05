<?php

namespace App\Http\Controllers;

use App\Http\Resources\PrescriptionResource;
use App\Models\Patient;
use App\Models\Pharmacist;
use App\Models\Prescription;
use App\Http\Requests\StorePrescriptionRequest;
use App\Http\Requests\UpdatePrescriptionRequest;
use App\Traits\ApiResponder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    use ApiResponder;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Authenticatable $user)
    {
        $role = $user->role;
        $prescriptions = $user->$role->prescriptions()->orderByDesc('updated_at')->get();
        Prescription::lazyLoadOnRole($prescriptions, $role);

        return $this->success(PrescriptionResource::collection($prescriptions));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePrescriptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePrescriptionRequest $request, Authenticatable $user, Patient $patient)
    {
        $this->authorize('write', [Prescription::class, $patient]);

        $prescription = new Prescription($request->only(['text']));
        $prescription->patient_id = $patient->user_id;

        $user->doctor->prescriptions()->save($prescription);
        $prescription->refresh();
        return $this->success($prescription, 'Prescription created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function show(Prescription $prescription)
    {
        $this->authorize('show', $prescription);
        Prescription::lazyLoadOnRole($prescription, Auth::user()->role);

        return $this->success(new PrescriptionResource($prescription));
    }

    public function sendToPharmacist(Prescription $prescription, Pharmacist $pharmacist)
    {
        $this->authorize('sendToPharmacy', $prescription);

        $prescription->pharmacist_id = $pharmacist->user_id;
        $prescription->status = 'sent';
        $prescription->save();

        return $this->success(new PrescriptionResource($prescription), 'Prescription sent to pharmacy.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePrescriptionRequest  $request
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePrescriptionRequest $request, Prescription $prescription)
    {
        //
    }
}
