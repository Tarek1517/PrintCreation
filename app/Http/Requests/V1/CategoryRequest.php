<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

 
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable',
            'parent_id' => 'nullable|integer',
            'icon' => 'nullable|mimes:png,jpg,jpeg,webp,avif',
            'banner' => 'nullable|mimes:png,jpg,jpeg,webp,avif',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'order_number' => 'required|integer'
        ];
    }
    protected  $stopOnFirstFailure = true;
}
