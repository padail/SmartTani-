<?php

use App\Http\Controllers\Api\IoT\SoilReadingApiController;
use App\Http\Controllers\Api\IoT\WaterReadingApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/iot')
    ->middleware(['throttle:60,1', 'iot.device'])
    ->group(function () {
        Route::post('/soil-readings', [SoilReadingApiController::class, 'store'])
            ->name('api.iot.soil-readings.store');

        Route::post('/water-readings', [WaterReadingApiController::class, 'store'])
            ->name('api.iot.water-readings.store');
    });