<?php

namespace App\Http\Controllers;

use App\Http\Resources\NurseResource;
use App\Models\Nurse;
use App\Http\Requests\StoreNurseRequest;
use App\Http\Requests\NurseRequest;
use App\Traits\ApiResponder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NurseController extends Controller
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
            ->select(['users.id', 'fname', 'lname', 'gender'])
            ->join('nurses as n', 'users.id', '=', 'n.user_id')
            ->where('role', 'nurse');
        if ($user->role !== 'admin') {
            $query = $query->join('documents', 'n.document_id', '=', 'documents.id')
                ->where('documents.verified', true)
                ->orderBy('lname', 'asc');
        } else {
            $query = $query->leftJoin('documents', 'n.document_id', '=', 'documents.id')
                ->orderBy('documents.verified')
                ->orderBy('documents.updated_at')
                ->orderByDesc('n.updated_at');
        }
        $query = $query->paginate(10);

        return $this->success($query);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Nurse $nurse
     * @return \Illuminate\Http\Response
     */
    public function show(Nurse $nurse)
    {
        return new NurseResource($nurse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\NurseRequest $request
     * @param \App\Models\Nurse $nurse
     * @return \Illuminate\Http\Response
     */
    public function update(NurseRequest $request, Authenticatable $user)
    {
        $fields = $request->all();

        $request->whenHas('image', function ($input) use (&$fields) {
            $fields['image'] = base64_decode($input);
        });
        $user->nurse()->update($fields);

        return $this->success(new NurseResource($user->nurse), 'Edited.');
    }

    public function imageShow(Nurse $nurse)
    {
        return response($nurse->image)
            ->header('Content-Type', $nurse->image_type);
    }
}
