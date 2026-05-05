<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
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
            //
        'title' => 'string|max:255',
        'teacher_id' => 'exists:teachers,id',
        'description' => 'string|max:1000',
        'specialization' => 'string|max:255',
        'duration' => 'integer|min:1',
        'price' => 'numeric|min:0',
        'course_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }


    public function messages()
    {
        return[
        'title.required' => 'Title is required.',
        'title.string' => 'Title must be a valid text.',
        'title.max' => 'Title must not exceed 255 characters.',

        'teacher_id.exists' => 'Selected teacher is invalid.',

        'description.required' => 'Description is required.',
        'description.string' => 'Description must be valid text.',
        'description.max' => 'Description must not exceed 1000 characters.',

        'specialization.required' => 'Specialization is required.',
        'specialization.string' => 'Specialization must be valid text.',
        'specialization.max' => 'Specialization must not exceed 255 characters.',

        'duration.required' => 'Duration is required.',
        'duration.integer' => 'Duration must be a number.',
        'duration.min' => 'Duration must be at least 1.',

        'price.required' => 'Price is required.',
        'price.numeric' => 'Price must be a valid number.',
        'price.min' => 'Price cannot be negative.',

        'course_cover.image' => 'File must be an image.',
        'course_cover.mimes' => 'Image must be jpg, jpeg or png.',
        'course_cover.max' => 'Image size must not exceed 2MB.',
        ];
    }
}
