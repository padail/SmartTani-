<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoilReading extends Model
{
    protected $fillable = [
        'device_id',
        'nitrogen',
        'phosphorus',
        'potassium',
        'temperature',
        'moisture',
        'ph',
        'ec',
        'latitude',
        'longitude',
        'status',
        'recorded_at',
        'raw_payload',
    ];

    protected function casts(): array
    {
        return [
            'nitrogen' => 'decimal:2',
            'phosphorus' => 'decimal:2',
            'potassium' => 'decimal:2',
            'temperature' => 'decimal:2',
            'moisture' => 'decimal:2',
            'ph' => 'decimal:2',
            'ec' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'recorded_at' => 'datetime',
            'raw_payload' => 'array',
        ];
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}