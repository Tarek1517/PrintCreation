<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'product' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|min:11|max:11',
            'email' => 'nullable|email',
            'address' => 'nullable|string|max:255'
        ];
    }

    protected  $stopOnFirstFailure = true;
}
