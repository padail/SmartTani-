<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class OrderManagementController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();

        $orders = Order::query()
            ->with(['buyer:id,name,email', 'payment', 'items.product:id,name,owner_id'])
            ->when($user->role === 'owner', function ($query) use ($user) {
                $query->whereHas('items.product', function ($subQuery) use ($user) {
                    $subQuery->where('owner_id', $user->id);
                });
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('order_code', 'like', "%{$search}%")
                        ->orWhere('recipient_name', 'like', "%{$search}%")
                        ->orWhere('recipient_phone', 'like', "%{$search}%")
                        ->orWhereHas('buyer', function ($buyerQuery) use ($search) {
                            $buyerQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('transactions.orders.index', [
            'orders' => $orders,
            'search' => $search,
            'status' => $status,
            'routePrefix' => $this->routePrefix($user->role),
        ]);
    }

    public function show(Request $request, Order $order): View
    {
        $this->authorizeOrder($request, $order);

        $order->load(['buyer:id,name,email', 'payment', 'items.product:id,name,owner_id', 'buyerAddress']);

        $visibleItems = $request->user()->role === 'owner'
            ? $order->items->filter(fn ($item) => (int) $item->product?->owner_id === (int) $request->user()->id)
            : $order->items;

        return view('transactions.orders.show', [
            'order' => $order,
            'visibleItems' => $visibleItems,
            'routePrefix' => $this->routePrefix($request->user()->role),
        ]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $this->authorizeOrder($request, $order);

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'waiting_payment',
                    'paid',
                    'processing',
                    'ready',
                    'completed',
                    'cancelled',
                    'expired',
                ]),
            ],
        ]);

        if ($request->user()->role === 'owner') {
            $allowedOwnerStatuses = ['processing', 'ready', 'completed', 'cancelled'];

            if (! in_array($validated['status'], $allowedOwnerStatuses, true)) {
                return back()->with('error', 'Owner hanya dapat mengubah status operasional pesanan.');
            }

            if (! in_array($order->status, ['paid', 'processing', 'ready'], true)) {
                return back()->with('error', 'Status pesanan belum dapat diproses oleh owner.');
            }
        }

        $order->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    private function authorizeOrder(Request $request, Order $order): void
    {
        if ($request->user()->role === 'admin') {
            return;
        }

        $hasOwnerItem = $order->items()
            ->whereHas('product', function ($query) use ($request) {
                $query->where('owner_id', $request->user()->id);
            })
            ->exists();

        abort_unless($hasOwnerItem, 403);
    }

    private function routePrefix(string $role): string
    {
        return $role === 'admin'
            ? 'admin.orders'
            : 'owner.orders';
    }
}