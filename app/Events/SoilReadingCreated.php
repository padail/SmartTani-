<?php

namespace App\Events;

use App\Models\SoilReading;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SoilReadingCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public SoilReading $soilReading)
    {
        $this->soilReading->loadMissing('device:id,device_code,name,location_name');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('monitoring'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'soil.reading.created';
    }

    public function broadcastWith(): array
    {
        return [
            'reading' => [
                'id' => $this->soilReading->id,
                'device' => [
                    'id' => $this->soilReading->device?->id,
                    'device_code' => $this->soilReading->device?->device_code,
                    'name' => $this->soilReading->device?->name,
                    'location_name' => $this->soilReading->device?->location_name,
                ],
                'nitrogen' => $this->soilReading->nitrogen,
                'phosphorus' => $this->soilReading->phosphorus,
                'potassium' => $this->soilReading->potassium,
                'temperature' => $this->soilReading->temperature,
                'moisture' => $this->soilReading->moisture,
                'ph' => $this->soilReading->ph,
                'ec' => $this->soilReading->ec,
                'latitude' => $this->soilReading->latitude,
                'longitude' => $this->soilReading->longitude,
                'status' => $this->soilReading->status,
                'recorded_at' => $this->soilReading->recorded_at?->toDateTimeString(),
            ],
        ];
    }
}