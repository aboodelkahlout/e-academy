<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchedulesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->teacher;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
        {
            return [
                'date' => ['required', 'date'],
                'start_time' => ['required', 'date_format:H:i' ,'before:end_time'],
                'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
                'is_available' => ['required', 'boolean'],
                'link'=>['required']
            ];
        }

        public function messages(): array
        {
            return [
                'date.required' => 'التاريخ مطلوب',
                'date.date' => 'صيغة التاريخ غير صحيحة',

                'start_time.required' => 'وقت البداية مطلوب',
                'start_time.date_format' => 'صيغة وقت البداية غير صحيحة',

                'end_time.required' => 'وقت النهاية مطلوب',
                'end_time.date_format' => 'صيغة وقت النهاية غير صحيحة',
                'end_time.after' => 'وقت النهاية يجب أن يكون بعد وقت البداية',

                'is_available.required' => 'حالة الموعد مطلوبة',
                'is_available.boolean' => 'قيمة الحالة غير صحيحة',
            ];
        }
}
