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
}   