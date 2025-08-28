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
        Schema::create('brands', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger('vendor_id');
            $table->string("name");
            $table->string("slug")->unique();
            $table->text("description")->nullable();
            $table->string("image")->nullable();
            $table->enum("status", ["active", "inactive"])->default("active");
            $table->softDeletes();
            $table->timestamps();
            // Indexes
            $table->index('vendor_id');
            // Foreign Key
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
