<?php

namespace App\Services\Marketplace;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShippingRateService
{
    public function calculate(string $destinationId, int $weightGram, ?string $courier = null): array
    {
        $apiKey = config('services.rajaongkir.api_key');
        $origin = config('services.rajaongkir.origin_district_id');
        $baseUrl = rtrim(config('services.rajaongkir.base_url'), '/');
        $courier = $courier ?: config('services.rajaongkir.default_courier');

        if (! $apiKey || ! $origin) {
            return $this->fallbackRates($courier);
        }

        try {
            $response = Http::asForm()
                ->withHeaders([
                    'key' => $apiKey,
                ])
                ->timeout(15)
                ->post($baseUrl.'/calculate/district/domestic-cost', [
                    'origin' => $origin,
                    'destination' => $destinationId,
                    'weight' => max($weightGram, 1),
                    'courier' => $courier,
                    'price' => 'lowest',
                ]);

            if (! $response->successful()) {
                Log::warning('RajaOngkir calculate failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return $this->fallbackRates($courier);
            }

            return $this->normalizeRates($response->json());
        } catch (\Throwable $exception) {
            Log::warning('RajaOngkir calculate exception', [
                'message' => $exception->getMessage(),
            ]);

            return $this->fallbackRates($courier);
        }
    }

    public function findSelectedRate(
        string $destinationId,
        int $weightGram,
        string $courier,
        string $service,
        float $fallbackCost,
        ?string $fallbackEtd = null
    ): array {
        $rates = $this->calculate($destinationId, $weightGram, $courier);

        foreach ($rates as $rate) {
            if (
                strtolower($rate['courier']) === strtolower($courier)
                && strtolower($rate['service']) === strtolower($service)
            ) {
                return $rate;
            }
        }

        return [
            'courier' => $courier,
            'service' => $service,
            'description' => $service,
            'cost' => $fallbackCost,
            'etd' => $fallbackEtd,
        ];
    }

    private function normalizeRates(array $payload): array
    {
        $data = $payload['data'] ?? null;

        if (is_array($data)) {
            return collect($data)
                ->map(function (array $item) {
                    return [
                        'courier' => strtolower($item['code'] ?? $item['courier'] ?? $item['name'] ?? '-'),
                        'service' => (string) ($item['service'] ?? $item['type'] ?? '-'),
                        'description' => (string) ($item['description'] ?? $item['name'] ?? $item['service'] ?? '-'),
                        'cost' => (float) ($item['cost'] ?? $item['price'] ?? 0),
                        'etd' => (string) ($item['etd'] ?? $item['duration'] ?? '-'),
                    ];
                })
                ->filter(fn ($item) => $item['cost'] > 0)
                ->values()
                ->all();
        }

        $oldResults = $payload['rajaongkir']['results'] ?? [];

        $rates = [];

        foreach ($oldResults as $result) {
            $courierCode = strtolower($result['code'] ?? '-');

            foreach (($result['costs'] ?? []) as $costItem) {
                $firstCost = $costItem['cost'][0] ?? [];

                $rates[] = [
                    'courier' => $courierCode,
                    'service' => (string) ($costItem['service'] ?? '-'),
                    'description' => (string) ($costItem['description'] ?? '-'),
                    'cost' => (float) ($firstCost['value'] ?? 0),
                    'etd' => (string) ($firstCost['etd'] ?? '-'),
                ];
            }
        }

        return collect($rates)
            ->filter(fn ($item) => $item['cost'] > 0)
            ->values()
            ->all();
    }

    private function fallbackRates(?string $courier): array
    {
        $firstCourier = explode(':', $courier ?: 'jne')[0];

        return [
            [
                'courier' => $firstCourier,
                'service' => 'REG',
                'description' => 'Reguler',
                'cost' => 25000,
                'etd' => '2-4 hari',
            ],
            [
                'courier' => $firstCourier,
                'service' => 'ECO',
                'description' => 'Ekonomi',
                'cost' => 18000,
                'etd' => '4-7 hari',
            ],
        ];
    }
}