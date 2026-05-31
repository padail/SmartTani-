<?php

use App\Http\Controllers\Api\IoT\SoilReadingApiController;
use App\Http\Controllers\Api\IoT\WaterReadingApiController;
use App\Http\Controllers\Payment\MidtransNotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/iot')
    ->middleware(['throttle:60,1', 'iot.device'])
    ->group(function () {
        Route::post('/soil-readings', [SoilReadingApiController::class, 'store'])
            ->name('api.iot.soil-readings.store');

        Route::post('/water-readings', [WaterReadingApiController::class, 'store'])
            ->name('api.iot.water-readings.store');
    });
Route::post('/v1/payments/midtrans/notification', MidtransNotificationController::class)
    ->name('api.payments.midtrans.notification');