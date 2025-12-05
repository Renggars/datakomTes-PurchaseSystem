<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowPurchaseRequest extends FormRequest
{
    public function authorize()
    {
        // Semua user yang login diizinkan
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer|exists:requests,id'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'ID request wajib diisi.',
            'id.integer' => 'ID request harus berupa angka.',
            'id.exists' => 'Request tidak ditemukan.'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}
