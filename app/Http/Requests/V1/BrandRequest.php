<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:brands,name,',
            'slug' => 'nullable|string|max:255|unique:brands,slug,',
            'logo' => 'nullable|mimes:png,jpg,jpeg,webp',
            'order_number' => 'required:integer',
            'banner' => 'nullable|mimes:png,jpg,jpeg,webp',
            'description' => 'nullable|string',
            'status' => 'required',
        ];
    }
    protected $stopOnFirstFailure = true;
}