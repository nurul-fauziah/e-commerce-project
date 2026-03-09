<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'variant_details' => ['required', 'string', 'max:255'],
            'variant_id' => ['required', 'integer', 'min:1'],
            'product_id' => ['required', 'integer', 'exists:st_products,id'],
        ];
    }
}