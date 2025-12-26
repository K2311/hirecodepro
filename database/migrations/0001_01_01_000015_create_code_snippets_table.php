<?php
// database/migrations/0001_01_01_000015_create_code_snippets_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('code_snippets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('code');
            $table->string('language');
            $table->json('tags')->nullable();

            // SEO
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_description', 300)->nullable();

            // Stats
            $table->integer('view_count')->default(0);
            $table->integer('download_count')->default(0);

            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('code_snippets');
    }
};