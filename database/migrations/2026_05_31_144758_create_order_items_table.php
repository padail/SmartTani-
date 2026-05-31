<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete();

            $table->foreignIdFor(Product::class)
                ->nullable()
                ->nullOnDelete();

            $table->string('product_name');
            $table->string('product_sku')->nullable();
            $table->unsignedInteger('quantity');
            $table->string('unit', 30)->default('kg');
            $table->unsignedInteger('weight_gram')->default(0);
            $table->decimal('price', 15, 2);
            $table->decimal('subtotal', 15, 2);

            $table->timestamps();

            $table->index(['order_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};