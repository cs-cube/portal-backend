<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\College\CollegeStoreRequest;
use App\Http\Requests\College\CollegeUpdateRequest;
use App\Http\Resources\CollegeResource;
use App\Models\College;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = College::query();

        $query->search( $request->q );

        $query->with('departments');

        $colleges = $query->paginate($this->page_size);

        return CollegeResource::collection($colleges);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\College\CollegeStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollegeStoreRequest $request)
    {
        $data = $request->validated();

        $college = College::create($data);

        return new CollegeResource($college);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function show(College $college)
    {
        $college->load('departments');
        return new CollegeResource($college);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\College\CollegeUpdateRequest  $request
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function update(CollegeUpdateRequest $request, College $college)
    {
        $data = $request->validated();

        $college->update($data);

        return new CollegeResource($college);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function destroy(College $college)
    {
        //
    }
}
