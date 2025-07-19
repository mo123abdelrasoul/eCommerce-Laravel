<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('is_delete');
            $table->softDeletes(); // Adds deleted_at column
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('is_delete');
            $table->softDeletes(); // Adds deleted_at column
        });
    }

    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->boolean('is_delete')->default(false);
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->boolean('is_delete')->default(false);
        });
    }
};
