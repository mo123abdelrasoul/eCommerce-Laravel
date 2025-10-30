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
        Schema::create('vendor_shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('shipping_method_id')->constrained('shipping_methods')->cascadeOnDelete();
            $table->foreignId('shipping_region_id')->constrained('shipping_regions')->cascadeOnDelete();
            $table->decimal('min_weight', 10, 2)->default(0);
            $table->decimal('max_weight', 10, 2)->nullable();
            $table->decimal('rate', 10, 2);
            $table->timestamps();

            $table->unique(['vendor_id', 'shipping_method_id', 'shipping_region_id', 'min_weight', 'max_weight'], 'unique_rate_row');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_shipping_rates');
    }
};
