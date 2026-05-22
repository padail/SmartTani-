<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    protected $fillable = [
        'device_code',
        'name',
        'type',
        'location_name',
        'latitude',
        'longitude',
        'api_key_hash',
        'status',
        'last_seen_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'last_seen_at' => 'datetime',
        ];
    }

    public function soilReadings(): HasMany
    {
        return $this->hasMany(SoilReading::class);
    }

    public function waterReadings(): HasMany
    {
        return $this->hasMany(WaterReading::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}