<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDrugRequest;
use App\Http\Requests\UpdateDrugRequest;
use App\Models\Drug;
use App\Traits\ApiResponder;
use Illuminate\Contracts\Auth\Authenticatable;

class DrugController extends Controller
{
    use ApiResponder;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Authenticatable $user)
    {
        $drugs = $user->pharmacist->drugs()->orderBy('name')->get();
        return $this->success($drugs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreDrugRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDrugRequest $request, Authenticatable $user)
    {
        $drug = new Drug($request->all());
        $user->pharmacist->drugs()->save($drug);
        return $this->success($drug, 'Drug created.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Drug $drug
     * @return \Illuminate\Http\Response
     */
    public function show(Drug $drug)
    {
        $this->authorize('access', $drug);

        return $this->success($drug);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateDrugRequest $request
     * @param \App\Models\Drug $drug
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDrugRequest $request, Drug $drug)
    {
        $this->authorize('access', $drug);
        $drug->update($request->all());
        return $this->success($drug, 'Drug updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Drug $drug
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drug $drug)
    {
        $this->authorize('access', $drug);
        $drug->delete();
        return $this->success(null, 'Drug deleted.');
    }
}
