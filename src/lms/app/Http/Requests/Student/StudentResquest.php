<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentResquest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|regex:/(^[A-Za-z0-9_-_ ]+$)+/',
            'last_name'  => 'required|regex:/(^[A-Za-z0-9_-_ ]+$)+/',
            'phone'      => 'required',
            'address'   =>  'required',
            'birthday'  =>  'required',
            'email'      => 'required|unique:users|email',
            
        ];
    }
}
