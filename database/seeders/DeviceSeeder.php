<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        $apiKey = env('DEMO_IOT_API_KEY', 'demo-iot-key-123');

        Device::updateOrCreate(
            ['device_code' => 'SOIL-001'],
            [
                'name' => 'Sensor Tanah Lahan Melon 1',
                'type' => 'soil',
                'location_name' => 'Lahan Melon Desa Tanggumong',
                'latitude' => -7.1970000,
                'longitude' => 113.2390000,
                'api_key_hash' => Hash::make($apiKey),
                'status' => 'active',
            ]
        );

        Device::updateOrCreate(
            ['device_code' => 'WATER-001'],
            [
                'name' => 'Sensor Air Nutrisi 1',
                'type' => 'water',
                'location_name' => 'Tandon Air Nutrisi',
                'latitude' => -7.1970000,
                'longitude' => 113.2390000,
                'api_key_hash' => Hash::make($apiKey),
                'status' => 'active',
            ]
        );
    }
}