<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class ProductReviewRequest extends FormRequest
{
   
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
            'user_id' => 'nullable|integer',
            'product_id' => 'required|integer',
            'rating' => 'required',
            'title' => 'nullable|string|max:255',
            'review' => 'nullable|string|max:1000',
            'author_name' => 'nullable|string|max:255',
            'status' => 'nullable|in:approved,pending,cancelled',
            'answer' => 'nullable|string'
        ];
    }

    protected $stopOnFirstFailure = true;
}
