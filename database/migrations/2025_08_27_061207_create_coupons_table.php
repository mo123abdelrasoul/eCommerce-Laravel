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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->foreignId('vendor_id')
                ->nullable()
                ->constrained('vendors')
                ->onDelete('cascade');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->enum('discount_type', ['percentage', 'fixed_cart', 'fixed_product']);
            $table->decimal('discount_value', 8, 2);
            $table->decimal('max_discount', 8, 2)->nullable();
            $table->decimal('min_order_amount', 8, 2)->nullable();
            $table->decimal('max_order_amount', 8, 2)->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_limit_per_user')->nullable();
            $table->boolean('applies_to_all_products')->default(true);
            $table->boolean('applies_to_all_categories')->default(true);
            $table->json('excluded_product_ids')->nullable();
            $table->json('excluded_category_ids')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->enum('status', ['active', 'expired', 'disabled'])->default('active');
            $table->integer('times_used')->default(0);
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
