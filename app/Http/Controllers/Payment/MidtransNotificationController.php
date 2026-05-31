<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\Marketplace\MidtransPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MidtransNotificationController extends Controller
{
    public function __invoke(Request $request, MidtransPaymentService $paymentService): JsonResponse
    {
        $paymentService->handleNotification($request->all());

        return response()->json([
            'message' => 'Notification processed.',
        ]);
    }
}