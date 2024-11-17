<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'title' => 'required|string|unique:products|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|integer',
            'created_by' => 'nullable|integer',
            'slug' => 'nullable',
            'cover_image' => 'required|mimes:png,jpg,jpeg,webp,avif',
            'hover_image' => 'nullable|mimes:png,jpg,jpeg,webp,avif',
            'short_description' => 'nullable|mimes:mp4',
            'youtube_video' => 'nullable|string',
            'short_description' => 'nullable|string',
            'product_info' => 'nullable|string',
            'specification' => 'nullable|string',
            'sku' => 'nullable|string',
            'stock' => 'nullable|integer',
            'bar_code' => 'nullable|string|max:255',
            'price' => 'required|integer|min:0',
            'discount_price' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'key_features' => 'nullable|array',
            'key_features*name' => 'nullable|string',
			'attachment' => 'boolean|required',
			'attachment_type' => 'string|nullable',
			'status' => 'boolean|required',
			'is_variant' => 'boolean|required'
        ];
    }

    protected $stopOnFirstFailure = true;
}
