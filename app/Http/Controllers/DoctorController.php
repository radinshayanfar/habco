<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\DoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Traits\ApiResponder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            ->select(['users.id', 'fname', 'lname', 'gender', 'd.specialization as specialization'])
            ->join('doctors as d', 'users.id', '=', 'd.user_id')
            ->where('role', 'doctor')
            ->join('documents', 'd.document_id', '=', 'documents.id')
            ->where('documents.verified', true)
            ->orderBy('specialization', 'asc')
            ->orderBy('lname', 'asc');
        $request->whenHas('query', function ($input) use (&$query, $request) {
            $loweredQuery = Str::lower($input);
            $query = $query->where(DB::raw("LOWER({$request->queryBy})"), 'like', "%{$loweredQuery}%");
        });
        $query = $query->paginate(10);

        return $this->success($query);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        return new DoctorResource($doctor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\DoctorRequest $request
     * @param Authenticatable $user
     * @return \Illuminate\Http\Response
     */
    public function update(DoctorRequest $request, Authenticatable $user)
    {
        $fields = $request->all();

        $request->whenHas('image', function ($input) use ($fields) {
            $fields['image'] = base64_decode($input);
        });
        $user->doctor()->update($fields);

        return $this->success(new DoctorResource($user->doctor), 'Edited.');
    }

    public function imageShow(Doctor $doctor)
    {
        return response($doctor->image)
            ->header('Content-Type', $doctor->image_type);
    }
}
