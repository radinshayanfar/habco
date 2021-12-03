<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmacistController extends Controller
{
    use ApiResponder;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = DB::table('users')
            ->select(['users.id', 'fname', 'lname', 'address', 'phone'])
            ->join('pharmacists as ph', 'users.id', '=', 'ph.user_id')
            ->where('role', 'pharmacist')
            ->join('documents as d', 'ph.cv_id', '=', 'd.id')
            ->where('d.verified', true)
            ->orderBy('lname', 'asc')->paginate(10);

        return $this->success($query);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Pharmacist $pharmacist
     * @return \Illuminate\Http\Response
     */
    public function show(Pharmacist $pharmacist)
    {
        return $this->success($pharmacist);
    }
}
