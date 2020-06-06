<?php

namespace App\Http\Requests\College;

use Illuminate\Foundation\Http\FormRequest;

class CollegeStoreRequest extends FormRequest
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
            'name' => 'required|max:100|unique:colleges,name',
            'code' => 'required|max:10|unique:colleges,code',
        ];
    }
}
