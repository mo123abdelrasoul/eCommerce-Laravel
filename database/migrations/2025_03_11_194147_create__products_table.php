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
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name");
            $table->text("description");
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->string("image");
            $table->boolean("status")->default(true);
            $table->softDeletes();
            $table->timestamps();

            // Foreign Key
            $table->foreign("parent_id")->references("id")->on("categories")->onDelete("cascade");
        });


        

        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name");
            $table->text("description");
            $table->decimal("price", 8, 2);
            $table->integer("quantity")->default(0);
            $table->string("image");
            $table->unsignedBigInteger("category_id");
            $table->enum('status', ['active', 'inactive'])->default("active");
            $table->string("sku")->unique();
            $table->decimal('discount', 8, 2)->default(0.00);
            $table->integer("views")->default(0);
            $table->integer("rating")->default(0);
            $table->unsignedBigInteger("vendor_id");
            $table->json("tags")->nullable();
            $table->boolean("out_of_stock")->default(false);
            $table->softDeletes();
            $table->timestamps();

            // Foreign Keys
            $table->foreign("category_id")->references("id")->on("categories")->onDelete("cascade");
            $table->foreign("vendor_id")->references("id")->on("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
