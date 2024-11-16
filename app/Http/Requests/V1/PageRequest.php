<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'title' => 'required|string|unique:pages',
            'slug' => 'string|nullable',
            'content' => 'required|string',
            'seo_title' => 'nullable|string',
            'seo_descrption' => 'nullable|string',
            'seo_image' => 'nullable|image'
        ];
    }

    protected $stopOnFirstFailure = true;
}