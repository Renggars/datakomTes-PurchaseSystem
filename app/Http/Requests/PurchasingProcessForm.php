<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchasingProcessForm extends FormRequest
{
    public function authorize()
    {
        return true; // sudah diamankan melalui middleware role:purchasing
    }

    public function rules()
    {
        return [
            'status' => 'required|in:checking_warehouse,by_vendor,selesai',
            'note'   => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'Status purchasing wajib diisi.',
            'status.in'       => 'Status hanya boleh checking_warehouse, by_vendor, atau selesai.',
            'note.max'        => 'Catatan maksimal 255 karakter.',
        ];
    }
}
