<?php
// database/migrations/0001_01_01_000019_create_page_views_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('session_id');
            $table->string('page_path', 500);
            $table->string('page_title')->nullable();
            $table->string('referrer', 500)->nullable();
            $table->string('device_type')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('country')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('is_bot')->default(false);
            $table->timestamps();

            $table->index('created_at');
            $table->index('page_path');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};