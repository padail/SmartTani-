<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'buyer_id',
        'status',
        'subtotal',
        'shipping_cost',
        'grand_total',
        'total_weight_gram',
        'recipient_name',
        'recipient_phone',
        'shipping_address',
        'destination_id',
        'destination_label',
        'shipping_courier',
        'shipping_service',
        'shipping_etd',
        'buyer_address_id',
        'notes',
        'paid_at',
        'stock_restored_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'grand_total' => 'decimal:2',
            'total_weight_gram' => 'integer',
            'paid_at' => 'datetime',
            'stock_restored_at' => 'datetime',
        ];
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
    public function buyerAddress(): BelongsTo
{
    return $this->belongsTo(BuyerAddress::class);
}
}