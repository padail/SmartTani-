<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class StoreSoilReadingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nitrogen' => ['nullable', 'numeric', 'min:0'],
            'phosphorus' => ['nullable', 'numeric', 'min:0'],
            'potassium' => ['nullable', 'numeric', 'min:0'],
            'temperature' => ['nullable', 'numeric', 'between:-20,80'],
            'moisture' => ['nullable', 'numeric', 'between:0,100'],
            'ph' => ['nullable', 'numeric', 'between:0,14'],
            'ec' => ['nullable', 'numeric', 'min:0'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'status' => ['nullable', 'in:normal,warning,danger,offline'],
            'recorded_at' => ['nullable', 'date'],
        ];
    }
}