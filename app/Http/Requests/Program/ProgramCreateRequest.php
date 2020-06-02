<?php

namespace App\Http\Requests\Program;

use Illuminate\Foundation\Http\FormRequest;

class ProgramCreateRequest extends FormRequest
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
            'name' => 'required|max:50|unique:programs,name',
            'code' => 'required|max:10|unique:programs,code',
            'no_of_years' => 'required|max:6|min:1',
            'department_id' => 'nullable|exists:departments,id'
        ];
    }
}
