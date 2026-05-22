<?php

namespace App\Services\Device;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DeviceApiKeyService
{
    public function generatePlainKey(string $deviceCode): string
    {
        $prefix = Str::of($deviceCode)
            ->upper()
            ->replaceMatches('/[^A-Z0-9\-]/', '')
            ->value();

        return $prefix.'-'.Str::upper(Str::random(40));
    }

    public function hashKey(string $plainKey): string
    {
        return Hash::make($plainKey);
    }
}