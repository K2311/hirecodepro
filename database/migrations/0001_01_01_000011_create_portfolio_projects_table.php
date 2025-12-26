<?php
// database/migrations/0001_01_01_000011_create_portfolio_projects_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('portfolio_projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('client_name')->nullable();
            $table->string('client_logo_url')->nullable();
            $table->string('project_type');

            // Project details
            $table->text('challenge')->nullable();
            $table->text('solution')->nullable();
            $table->text('result')->nullable();

            // Technical details
            $table->json('tech_stack')->nullable();
            $table->string('project_url')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('github_url')->nullable();

            // Media
            $table->string('cover_image_url')->nullable();
            $table->json('images')->nullable();
            $table->string('video_url')->nullable();

            // Display
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);

            // SEO
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_description', 300)->nullable();

            // Stats
            $table->integer('view_count')->default(0);

            $table->timestamps();
            $table->timestamp('published_at')->nullable();

            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_projects');
    }
};