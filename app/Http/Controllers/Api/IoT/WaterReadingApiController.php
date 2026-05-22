<?php

namespace App\Http\Controllers\Api\IoT;

use App\Events\WaterReadingCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Monitoring\StoreWaterReadingRequest;
use App\Models\Device;
use App\Services\Monitoring\MonitoringStatusService;
use Illuminate\Http\JsonResponse;

class WaterReadingApiController extends Controller
{
    public function store(
        StoreWaterReadingRequest $request,
        MonitoringStatusService $statusService
    ): JsonResponse {
        /** @var Device $device */
        $device = $request->attributes->get('iot_device');

        if (! in_array($device->type, ['water', 'mixed'], true)) {
            return response()->json([
                'message' => 'Device ini tidak terdaftar sebagai device monitoring air.',
            ], 422);
        }

        $validated = $request->validated();

        $reading = $device->waterReadings()->create([
            ...$validated,
            'status' => $validated['status'] ?? $statusService->classifyWater($validated),
            'recorded_at' => $validated['recorded_at'] ?? now(),
            'raw_payload' => $request->all(),
        ]);

        $device->forceFill([
            'latitude' => $validated['latitude'] ?? $device->latitude,
            'longitude' => $validated['longitude'] ?? $device->longitude,
            'last_seen_at' => now(),
        ])->save();

        WaterReadingCreated::dispatch($reading->fresh('device:id,device_code,name,location_name'));

        return response()->json([
            'message' => 'Data monitoring air berhasil disimpan.',
            'data' => [
                'id' => $reading->id,
                'device_code' => $device->device_code,
                'status' => $reading->status,
                'recorded_at' => $reading->recorded_at?->toDateTimeString(),
            ],
        ], 201);
    }
}
