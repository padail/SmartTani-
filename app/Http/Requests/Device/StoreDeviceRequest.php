<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDeviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'device_code' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Z0-9\-]+$/',
                Rule::unique('devices', 'device_code'),
            ],
            'name' => ['required', 'string', 'max:150'],
            'type' => ['required', Rule::in(['soil', 'water', 'mixed'])],
            'location_name' => ['nullable', 'string', 'max:150'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'status' => ['required', Rule::in(['active', 'inactive', 'maintenance'])],
        ];
    }

    public function messages(): array
    {
        return [
            'device_code.regex' => 'Kode device hanya boleh berisi huruf kapital, angka, dan tanda strip.',
        ];
    }
}