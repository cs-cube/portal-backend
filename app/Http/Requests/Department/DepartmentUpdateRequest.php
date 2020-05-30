<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentUpdateRequest extends FormRequest
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
            'name' => [
                        'required',
                        'max:100',
                        Rule::unique('departments', 'name')->ignore( $this->route('department') )
            ],
            'code' => [
                        'required',
                        'max:10',
                        Rule::unique('departments', 'code')->ignore( $this->route('department') )
            ],
            'college_id' => 'required|exists:colleges,id',
        ];
    }
}
