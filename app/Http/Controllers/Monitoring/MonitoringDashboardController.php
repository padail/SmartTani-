<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\SoilReading;
use App\Models\WaterReading;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class MonitoringDashboardController extends Controller
{
    public function index(): View
    {
        return view('monitoring.dashboard');
    }

    public function latest(): JsonResponse
    {
        $latestSoil = SoilReading::query()
            ->with('device:id,device_code,name,location_name')
            ->latest('recorded_at')
            ->first();

        $latestWater = WaterReading::query()
            ->with('device:id,device_code,name,location_name')
            ->latest('recorded_at')
            ->first();

        $soilHistory = SoilReading::query()
            ->with('device:id,device_code,name')
            ->latest('recorded_at')
            ->limit(10)
            ->get();

        $waterHistory = WaterReading::query()
            ->with('device:id,device_code,name')
            ->latest('recorded_at')
            ->limit(10)
            ->get();

        $onlineLimit = now()->subMinutes(10);

        return response()->json([
            'summary' => [
                'total_devices' => Device::count(),
                'online_devices' => Device::where('status', 'active')
                    ->where('last_seen_at', '>=', $onlineLimit)
                    ->count(),
                'soil_status' => $latestSoil?->status ?? 'offline',
                'water_status' => $latestWater?->status ?? 'offline',
                'last_update' => now()->toDateTimeString(),
            ],
            'latest_soil' => $latestSoil,
            'latest_water' => $latestWater,
            'soil_history' => $soilHistory,
            'water_history' => $waterHistory,
        ]);
    }
    public function chartData(): JsonResponse
{
    $limit = request()->integer('limit', 30);

    $limit = min(max($limit, 10), 120);

    $soilReadings = SoilReading::query()
        ->with('device:id,device_code,name')
        ->latest('recorded_at')
        ->limit($limit)
        ->get()
        ->reverse()
        ->values();

    $waterReadings = WaterReading::query()
        ->with('device:id,device_code,name')
        ->latest('recorded_at')
        ->limit($limit)
        ->get()
        ->reverse()
        ->values();

    return response()->json([
        'soil' => [
            'labels' => $soilReadings->map(fn ($item) => $item->recorded_at?->format('H:i:s')),
            'datasets' => [
                'nitrogen' => $soilReadings->map(fn ($item) => (float) $item->nitrogen),
                'phosphorus' => $soilReadings->map(fn ($item) => (float) $item->phosphorus),
                'potassium' => $soilReadings->map(fn ($item) => (float) $item->potassium),
                'temperature' => $soilReadings->map(fn ($item) => (float) $item->temperature),
                'moisture' => $soilReadings->map(fn ($item) => (float) $item->moisture),
                'ph' => $soilReadings->map(fn ($item) => (float) $item->ph),
                'ec' => $soilReadings->map(fn ($item) => (float) $item->ec),
            ],
        ],
        'water' => [
            'labels' => $waterReadings->map(fn ($item) => $item->recorded_at?->format('H:i:s')),
            'datasets' => [
                'ph' => $waterReadings->map(fn ($item) => (float) $item->ph),
                'tds' => $waterReadings->map(fn ($item) => (float) $item->tds),
                'ec' => $waterReadings->map(fn ($item) => (float) $item->ec),
                'battery' => $waterReadings->map(fn ($item) => (float) $item->battery),
            ],
        ],
    ]);
}
}   