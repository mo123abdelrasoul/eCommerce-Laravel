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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('weight', 10, 2)->default(0);
            $table->decimal('width', 10, 2)->nullable();
            $table->decimal('height', 10, 2)->nullable();
            $table->decimal('length', 10, 2)->nullable();
        });
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('carrier')->nullable();
            $table->decimal('price', 8, 2);
            $table->integer('delivery_time');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('shipping_method');
            $table->decimal('total_weight', 10, 2)->default(0)->after('shipping_cost');
            $table->string('tracking_number')->nullable();
            $table->foreignId('shipping_method_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
