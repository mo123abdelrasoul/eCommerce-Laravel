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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->string('status');
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_status');
            $table->string('payment_method')->nullable();
            $table->json('shipping_address');
            $table->json('billing_address')->nullable();
            $table->string('shipping_method');
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
