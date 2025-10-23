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
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->string('status');
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_status');
            $table->string('payment_method')->nullable();

            $table->json('shipping_address');
            $table->json('billing_address')->nullable();

            $table->foreignId('shipping_method_id')->nullable()->constrained('shipping_methods')->onDelete('set null');

            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total_weight', 10, 2)->default(0);

            $table->foreignId('shipping_policy_id')->nullable()->constrained('shipping_policies')->onDelete('set null');

            $table->string('tracking_number')->nullable();

            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->text('notes')->nullable();

            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');

            $table->decimal('sub_total', 10, 2);

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
