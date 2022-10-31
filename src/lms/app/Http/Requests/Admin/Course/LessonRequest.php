<?php

namespace App\Http\Requests\Admin\Course;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'name'      =>      ['required', 'max:255'],
            'status'    =>      ['integer', 'min:0'],
            'content'   =>      ['required', 'min:20'],
            'files.*'   =>      [
                                'file',
                                'mimes:ppt,pptx,doc,docx,pdf,xls,xlsx,mp4,avi,mp4v,mpg4,zip',                    
                                'max:1048576'
                                ],
        ];
    }
}
