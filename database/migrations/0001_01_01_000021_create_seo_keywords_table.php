<?php
// database/migrations/0001_01_01_000021_create_seo_keywords_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seo_keywords', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('keyword');
            $table->string('target_page', 500)->nullable();
            $table->integer('current_rank')->nullable();
            $table->integer('best_rank')->nullable();
            $table->integer('search_volume')->nullable();
            $table->integer('difficulty')->nullable();
            $table->boolean('is_tracking')->default(true);
            $table->date('last_checked')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_keywords');
    }
};