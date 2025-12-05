<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'division_id' => 'nullable|exists:divisions,id',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'end_date.after_or_equal' => 'End date harus lebih besar atau sama dengan start date.',
            'division_id.exists' => 'Division tidak valid.',
            'category_id.exists' => 'Category tidak valid.',
        ];
    }
}
