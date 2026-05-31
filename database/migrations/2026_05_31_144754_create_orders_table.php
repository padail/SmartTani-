<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_code')->unique();

            $table->foreignIdFor(User::class, 'buyer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->enum('status', [
                'pending',
                'waiting_payment',
                'paid',
                'processing',
                'ready',
                'completed',
                'cancelled',
                'expired',
            ])->default('pending');

            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->unsignedInteger('total_weight_gram')->default(0);

            $table->string('recipient_name');
            $table->string('recipient_phone', 30);
            $table->text('shipping_address');

            $table->string('destination_id')->nullable();
            $table->string('destination_label')->nullable();

            $table->string('shipping_courier', 50)->nullable();
            $table->string('shipping_service', 100)->nullable();
            $table->string('shipping_etd', 100)->nullable();

            $table->text('notes')->nullable();

            $table->timestamp('paid_at')->nullable();
            $table->timestamp('stock_restored_at')->nullable();

            $table->timestamps();

            $table->index(['buyer_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};