<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Traits\ApiResponder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;
use function MongoDB\BSON\toJSON;

class DoctorController extends Controller
{
    use ApiResponder;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
            'query' => 'string|nullable',
            'queryBy' => 'string|nullable|required_with:query|in:specialization,fname,lname,gender',
//            'sort' => 'string|in:asc,dsc',
//            'sortBy' => 'string|'
        ]);

        $query = DB::table('users')
            ->select(['users.id', 'fname', 'lname', 'gender', 'd.specialization as specialization', 'd.image as image'])
            ->join('doctors as d', 'users.id', '=', 'd.user_id')
            ->where('role', 'doctor')
            ->join('documents', 'd.document_id', '=', 'documents.id')
            ->where('documents.verified', true)
            ->orderBy('specialization', 'asc')
            ->orderBy('lname', 'asc');
        $request->whenHas('query', function ($input) use (&$query, $request) {
            $loweredQuery = Str::lower($request->input('query'));
            $query = $query->where(DB::raw("LOWER({$request->queryBy})"), 'like', "%{$loweredQuery}%");
        });
        $query = $query->paginate(10);

        return $this->success($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDoctorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDoctorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDoctorRequest  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
