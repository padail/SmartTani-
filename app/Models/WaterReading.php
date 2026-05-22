<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaterReading extends Model
{
    protected $fillable = [
        'device_id',
        'ph',
        'tds',
        'ec',
        'battery',
        'latitude',
        'longitude',
        'status',
        'recorded_at',
        'raw_payload',
    ];

    protected function casts(): array
    {
        return [
            'ph' => 'decimal:2',
            'tds' => 'decimal:2',
            'ec' => 'decimal:2',
            'battery' => 'decimal:2',
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