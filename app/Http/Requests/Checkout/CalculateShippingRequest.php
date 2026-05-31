<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CalculateShippingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'buyer';
    }

    public function rules(): array
    {
        return [
            'destination_id' => ['required', 'string', 'max:50'],
            'courier' => ['nullable', 'string', 'max:120'],
        ];
    }
}