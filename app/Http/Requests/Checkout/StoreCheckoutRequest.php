<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'buyer';
    }

    public function rules(): array
    {
        return [
            'buyer_address_id' => [
                'nullable',
                Rule::exists('buyer_addresses', 'id')->where('user_id', $this->user()->id),
            ],

            'recipient_name' => ['required_without:buyer_address_id', 'nullable', 'string', 'max:150'],
            'recipient_phone' => ['required_without:buyer_address_id', 'nullable', 'string', 'max:30'],
            'shipping_address' => ['required_without:buyer_address_id', 'nullable', 'string', 'max:1000'],

            'destination_id' => ['required', 'string', 'max:50'],
            'destination_label' => ['nullable', 'string', 'max:255'],

            'shipping_courier' => ['required', 'string', 'max:50'],
            'shipping_service' => ['required', 'string', 'max:100'],
            'shipping_cost' => ['required', 'numeric', 'min:0'],
            'shipping_etd' => ['nullable', 'string', 'max:100'],

            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}