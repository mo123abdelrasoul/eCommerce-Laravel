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
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_region_id')->constrained();
            $table->decimal('min_weight', 10, 2)->default(0);
            $table->decimal('max_weight', 10, 2)->nullable();
            $table->decimal('min_price', 10, 2)->default(0);
            $table->decimal('max_price', 10, 2)->nullable();
            $table->decimal('rate', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
