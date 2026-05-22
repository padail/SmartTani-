<?php

use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class, 'owner_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignIdFor(ProductCategory::class, 'category_id')
                ->nullable()
                ->nullOnDelete();

            $table->string('name', 160);
            $table->string('slug', 180)->unique();
            $table->string('sku', 80)->nullable()->unique();

            $table->string('short_description', 255)->nullable();
            $table->longText('description')->nullable();

            $table->decimal('price', 15, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->string('unit', 30)->default('kg');
            $table->unsignedInteger('minimum_order')->default(1);

            $table->date('harvest_date')->nullable();
            $table->string('main_image')->nullable();

            $table->enum('status', ['draft', 'active', 'inactive', 'out_of_stock'])
                ->default('draft');

            $table->boolean('is_featured')->default(false);

            $table->string('meta_title', 160)->nullable();
            $table->string('meta_description', 255)->nullable();

            $table->timestamps();

            $table->index(['owner_id', 'status']);
            $table->index(['category_id', 'status']);
            $table->index(['status', 'created_at']);
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};