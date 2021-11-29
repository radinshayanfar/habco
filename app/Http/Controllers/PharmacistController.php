<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use App\Http\Requests\StorePharmacistRequest;
use App\Http\Requests\UpdatePharmacistRequest;

class PharmacistController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePharmacistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePharmacistRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pharmacist  $pharmacist
     * @return \Illuminate\Http\Response
     */
    public function show(Pharmacist $pharmacist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePharmacistRequest  $request
     * @param  \App\Models\Pharmacist  $pharmacist
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePharmacistRequest $request, Pharmacist $pharmacist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacist  $pharmacist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pharmacist $pharmacist)
    {
        //
    }
}
