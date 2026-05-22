<?php

use App\Models\Device;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soil_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Device::class)->constrained()->cascadeOnDelete();

            $table->decimal('nitrogen', 10, 2)->nullable();
            $table->decimal('phosphorus', 10, 2)->nullable();
            $table->decimal('potassium', 10, 2)->nullable();
            $table->decimal('temperature', 5, 2)->nullable();
            $table->decimal('moisture', 5, 2)->nullable();
            $table->decimal('ph', 4, 2)->nullable();
            $table->decimal('ec', 10, 2)->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->enum('status', ['normal', 'warning', 'danger', 'offline'])->default('normal');
            $table->timestamp('recorded_at')->useCurrent();
            $table->json('raw_payload')->nullable();

            $table->timestamps();

            $table->index(['device_id', 'recorded_at']);
            $table->index(['status', 'recorded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soil_readings');
    }
};