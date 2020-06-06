<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Student::class, 'student');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = Student::query();

        $query->search($request->q);

        $query->with('program');

        $query->sort();

        $students = $query->paginate($request->per_page);

        return StudentResource::collection($students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentStoreRequest $request)
    {
        $data = $request->validated();


        try{

            DB::beginTransaction();

            $student = $request->user()->created_students()->create($data);

            DB::commit();
            
            return new StudentResource($student);

        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {

        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(StudentUpdateRequest $request, Student $student)
    {

        $data = $request->validated();

        $student->update($data);

        return new StudentResource($student);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        
    }
}
