<?php

namespace App\Events;

use App\Models\WaterReading;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WaterReadingCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public WaterReading $waterReading)
    {
        $this->waterReading->loadMissing('device:id,device_code,name,location_name');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('monitoring'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'water.reading.created';
    }

    public function broadcastWith(): array
    {
        return [
            'reading' => [
                'id' => $this->waterReading->id,
                'device' => [
                    'id' => $this->waterReading->device?->id,
                    'device_code' => $this->waterReading->device?->device_code,
                    'name' => $this->waterReading->device?->name,
                    'location_name' => $this->waterReading->device?->location_name,
                ],
                'ph' => $this->waterReading->ph,
                'tds' => $this->waterReading->tds,
                'ec' => $this->waterReading->ec,
                'battery' => $this->waterReading->battery,
                'latitude' => $this->waterReading->latitude,
                'longitude' => $this->waterReading->longitude,
                'status' => $this->waterReading->status,
                'recorded_at' => $this->waterReading->recorded_at?->toDateTimeString(),
            ],
        ];
    }
}