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
        Schema::table('customer_chats', function (Blueprint $table) {
            $table->text('last_message')->nullable()->after('admin_id');
            $table->boolean('is_read')->default(false)->after('last_message_at');
            $table->unique(['user_id', 'admin_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_chats', function (Blueprint $table) {
            //
        });
    }
};
