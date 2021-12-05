<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstructionRequest;
use App\Http\Resources\InstructionResource;
use App\Models\Instruction;
use App\Models\Patient;
use App\Traits\ApiResponder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class InstructionController extends Controller
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
        $instructions = $user->$role->instructions()->orderByDesc('updated_at')->get();
        Instruction::lazyLoadOnRole($instructions, $role);

        return $this->success(InstructionResource::collection($instructions));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InstructionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstructionRequest $request, Authenticatable $user, Patient $patient)
    {
        $this->authorize('write', [Instruction::class, $patient]);

        $instruction = new Instruction($request->only(['text']));
        $instruction->patient_id = $patient->user_id;

        $user->nurse->instructions()->save($instruction);
        $instruction->refresh();
        return $this->success($instruction, 'Instruction created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instruction  $instruction
     * @return \Illuminate\Http\Response
     */
    public function show(Instruction $instruction)
    {
        $this->authorize('show', $instruction);
        Instruction::lazyLoadOnRole($instruction, Auth::user()->role);

        return $this->success(new InstructionResource($instruction));
    }
}
