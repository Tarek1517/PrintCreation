<?php

namespace App\Http\Requests\V1;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
			'country' => 'required',
			'city' => 'required',
			'shipping_area_id' => 'required',
			'address' => 'required|string',
			'phone' => 'nullable',
            'user_id' => 'nullable|exists:users,id',
            'sub_total' => 'nullable',
            'grand_total' => 'nullable',
            'vat' => 'nullable|numeric',
            'pay_bill' => 'nullable|numeric',
            'delivery_charge' => 'required|numeric',
            'pay_due' => 'nullable|numeric',
            'payment_method' => 'nullable|string|max:255',
            'payment_status' => 'nullable',
            'order_type' => 'nullable|in:customer,pos',
            'order_date' => 'nullable',
            'order_id' => 'nullable',
            'order_items' => 'required|array',
        ];
    }

    protected $stopOnFirstFailure = true;
}