<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'title' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:10',
        'specialization' => 'required|string|min:3|max:100',
        'duration' => 'required|numeric|min:1|max:250',
        'price' => 'required|numeric|min:0',
        'course_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'category_id'=>'required'
        ];
    }


     public  function messages() : array
    {
        return [
        'title.required' => 'The course title is required.',
        'title.min' => 'The course title must be at least 3 characters.',
        'title.max' => 'The course title may not be greater than 255 characters.',

        'description.required' => 'The course description is required.',
        'description.min' => 'The course description must be at least 10 characters.',


        'duration.required' => 'The course duration is required.',
        'duration.max' => 'The duration may not exceed 50 characters.',

        'price.required' => 'The course price is required.',
        'price.numeric' => 'The price must be a number.',
        'price.min' => 'The price must be at least 0.',

        'course_cover.image' => 'The file must be an image.',
        'course_cover.mimes' => 'The cover image must be a file of type: jpg, jpeg, png.',
        'course_cover.max' => 'The cover image size may not exceed 2MB.',

        'teacher_id.required' => 'Please select a teacher for this course.',
        'teacher_id.exists' => 'The selected teacher is invalid.',
        ];
    }
}
