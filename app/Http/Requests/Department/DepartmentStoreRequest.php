<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentStoreRequest extends FormRequest
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
            'name' => 'required|max:100|unique:departments,name',
            'code' => 'required|max:10|unique:departments,code',
            'college_id' => 'required|exists:colleges,id',
        ];
    }
}
