<?php

namespace App\Http\Requests\Student;

use App\Rules\NameRule;
use App\Rules\StudentIdPatternRule;
use App\Rules\StudentYearLevelRule;
use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_number' => [
                'required',
                'max:50',
                'unique:students,id_number',
                new StudentIdPatternRule()
            ], 
            'firstname' => [
                            'required',
                            'max:50',
                            new NameRule()
            ],
            'lastname' => [
                            'required',
                            'max:50',
                            new NameRule()
            ],
            'middlename' => [
                            'nullable',
                            'max:50',
                            new NameRule()
            ],
            'program_id' => 'required|exists:programs,id',
            'year_level' =>  [
                'required',
                'numeric',
                'min:1',
                new StudentYearLevelRule( $this->request->get('program_id') )
            ],
            'current_address' => 'nullable',
            'home_address' => 'nullable'
        ];
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'program_id.required' => 'Program enrolled in is required',
            'program_id.exists' => 'Program not exist',
            'year_level.min' => 'Year level is required'
        ];
    }
}
