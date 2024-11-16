<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class FooterRequest extends FormRequest
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
            'title' => 'required|string',
            'pages' => 'nullable|array',
            'content' => 'nullable|string',
            'order_number' => 'nullable|integer',
            'width' => 'nullable|integer'
        ];
    }

    protected $stopOnFristFailure = true;
}
