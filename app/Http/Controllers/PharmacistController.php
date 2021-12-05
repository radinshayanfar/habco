<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use App\Traits\ApiResponder;
use Illuminate\Contracts\Auth\Authenticatable;
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
    public function index(Request $request, Authenticatable $user)
    {
        $query = DB::table('users')
            ->select(['users.id', 'fname', 'lname', 'address', 'phone'])
            ->join('pharmacists as ph', 'users.id', '=', 'ph.user_id')
            ->where('role', 'pharmacist');
        if ($user->role !== 'admin') {
            $query = $query->join('documents', 'ph.cv_id', '=', 'documents.id')
                ->where('documents.verified', true)
                ->orderBy('lname', 'asc');
        } else {
            $query = $query->leftJoin('documents', 'ph.cv_id', '=', 'documents.id')
                ->orderBy('documents.verified')
                ->orderBy('documents.updated_at')
                ->orderByDesc('ph.updated_at');
        }
        $query = $query->paginate(10);

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
