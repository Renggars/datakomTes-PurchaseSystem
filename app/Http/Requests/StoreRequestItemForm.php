<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestItemForm extends FormRequest
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
            'item_name'   => 'required|string|max:150',
            'qty'         => 'required|integer|min:1',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'vendor_id'    => 'nullable|exists:vendors,id',
        ];
    }
}
