<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class StoreWaterReadingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ph' => ['nullable', 'numeric', 'between:0,14'],
            'tds' => ['nullable', 'numeric', 'min:0'],
            'ec' => ['nullable', 'numeric', 'min:0'],
            'battery' => ['nullable', 'numeric', 'between:0,100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'status' => ['nullable', 'in:normal,warning,danger,offline'],
            'recorded_at' => ['nullable', 'date'],
        ];
    }
}