<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalActionForm extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => 'required|in:APPROVED,REJECTED',
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'Status approval wajib diisi.',
            'status.in'       => 'Status hanya boleh APPROVED atau REJECTED.',
        ];
    }
}
