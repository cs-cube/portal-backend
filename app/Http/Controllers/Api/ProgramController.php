<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Program\ProgramCreateRequest;
use App\Http\Requests\Program\ProgramUpdateRequest;
use App\Http\Resources\ProgramResource;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Program::query();

        $query->search($request->q);

        $query->with('department');

        $programs = $query->paginate($request->per_page);

        return ProgramResource::collection($programs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Program\ProgramCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramCreateRequest $request)
    {
        $data = $request->validated();

        $program = Program::create($data);

        return new ProgramResource($program);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        $program->load(['students', 'department']);
        return new ProgramResource($program);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Program\ProgramUpdateRequest  $request
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(ProgramUpdateRequest $request, Program $program)
    {
        $data = $request->validated();
        $program->update($data);

        return new ProgramResource($program);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        //
    }
}
