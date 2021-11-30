<?php

namespace App\Http\Controllers;

use App\Models\DiseaseRecord;
use App\Http\Requests\StoreDiseaseRecordRequest;
use App\Http\Requests\UpdateDiseaseRecordRequest;
use App\Traits\ApiResponder;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Request;

class DiseaseRecordController extends Controller
{
    use ApiResponder;

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreDiseaseRecordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDiseaseRecordRequest $request, Authenticatable $user)
    {
        $record = $user->diseaseRecord()->create($request->all());
        return $this->success($record, "Record created.", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\DiseaseRecord $diseaseRecord
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Authenticatable $user)
    {
        return $this->success($user->diseaseRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateDiseaseRecordRequest $request
     * @param \App\Models\DiseaseRecord $diseaseRecord
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDiseaseRecordRequest $request, Authenticatable $user)
    {
        $diseaseRecord = $user->diseaseRecord;
        $diseaseRecord->update($request->all());
        return $this->success($diseaseRecord);
    }
}
