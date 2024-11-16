<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariationStorRequest extends FormRequest
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
            'product_id' => 'required|integer',
            'option' => 'required|integer',
            'variants' => 'required|array',
            'variants.*.id' => 'required|integer',
            'variants.*.name' => 'required',
            'variants.*.price' => 'required|integer',
            'variants.*.stock' => 'required|integer',
            'variants.*.sku' => 'required',
            'variants.*.image' => 'nullable|image',
        ];
    }

    protected $stopOnFirstFailure = true;
}
