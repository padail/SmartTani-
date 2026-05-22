<?php

namespace App\Services\Monitoring;

class MonitoringStatusService
{
    public function classifySoil(array $data): string
    {
        $danger = false;
        $warning = false;

        if (isset($data['ph'])) {
            $ph = (float) $data['ph'];

            if ($ph < 5.0 || $ph > 8.5) {
                $danger = true;
            } elseif ($ph < 5.5 || $ph > 7.8) {
                $warning = true;
            }
        }

        if (isset($data['moisture'])) {
            $moisture = (float) $data['moisture'];

            if ($moisture < 20 || $moisture > 95) {
                $danger = true;
            } elseif ($moisture < 35 || $moisture > 85) {
                $warning = true;
            }
        }

        if (isset($data['temperature'])) {
            $temperature = (float) $data['temperature'];

            if ($temperature < 10 || $temperature > 45) {
                $danger = true;
            } elseif ($temperature < 18 || $temperature > 38) {
                $warning = true;
            }
        }

        if ($danger) {
            return 'danger';
        }

        if ($warning) {
            return 'warning';
        }

        return 'normal';
    }

    public function classifyWater(array $data): string
    {
        $danger = false;
        $warning = false;

        if (isset($data['ph'])) {
            $ph = (float) $data['ph'];

            if ($ph < 4.5 || $ph > 9.0) {
                $danger = true;
            } elseif ($ph < 5.5 || $ph > 7.5) {
                $warning = true;
            }
        }

        if (isset($data['tds'])) {
            $tds = (float) $data['tds'];

            if ($tds > 1500) {
                $danger = true;
            } elseif ($tds > 1000) {
                $warning = true;
            }
        }

        if (isset($data['battery'])) {
            $battery = (float) $data['battery'];

            if ($battery <= 10) {
                $danger = true;
            } elseif ($battery <= 25) {
                $warning = true;
            }
        }

        if ($danger) {
            return 'danger';
        }

        if ($warning) {
            return 'warning';
        }

        return 'normal';
    }
}