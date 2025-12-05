<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexPurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => 'nullable|in:diajukan,menunggu_approval,approved,checking_warehouse,by_vendor,selesai,ditolak',
            'category_id' => 'nullable|exists:categories,id',
            'division_id' => 'nullable|exists:divisions,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ];
    }

    public function messages()
    {
        return [
            'status.in' => 'Status tidak valid.',
            'category_id.exists' => 'Kategori tidak valid.',
            'division_id.exists' => 'Divisi tidak valid.',
            'end_date.after_or_equal' => 'End date harus sama atau lebih besar dari start date.'
        ];
    }
}
