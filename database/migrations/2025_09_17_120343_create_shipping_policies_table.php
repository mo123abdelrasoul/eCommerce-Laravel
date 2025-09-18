<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipping_policies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['flat', 'weight', 'price', 'free']);
            $table->decimal('base_price', 10, 2)->nullable();
            $table->decimal('price_per_kg', 10, 2)->nullable();
            $table->decimal('free_shipping_threshold', 10, 2)->nullable();
            $table->json('weight_ranges')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_policies');
    }
};
