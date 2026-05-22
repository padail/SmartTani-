<?php

namespace App\Http\Middleware;

use App\Models\Device;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class DeviceApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $deviceCode = $request->header('X-Device-Code');
        $apiKey = $request->header('X-Device-Key');

        if (! $deviceCode || ! $apiKey) {
            return response()->json([
                'message' => 'Device code dan API key wajib dikirim.',
            ], 401);
        }

        $device = Device::where('device_code', $deviceCode)->first();

        if (! $device || ! Hash::check($apiKey, $device->api_key_hash)) {
            return response()->json([
                'message' => 'Device tidak valid.',
            ], 401);
        }

        if (! $device->isActive()) {
            return response()->json([
                'message' => 'Device tidak aktif.',
            ], 403);
        }

        $request->attributes->set('iot_device', $device);

        return $next($request);
    }
}