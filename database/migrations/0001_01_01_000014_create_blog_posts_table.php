<?php
// database/migrations/0001_01_01_000014_create_blog_posts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt', 300)->nullable();
            $table->text('content');
            $table->foreignUuid('category_id')->nullable()->constrained('blog_categories')->onDelete('set null');
            $table->foreignUuid('author_id')->nullable()->constrained('users')->onDelete('set null');

            // Media
            $table->string('cover_image_url')->nullable();

            // SEO
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->string('meta_keywords', 500)->nullable();

            // Status
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);

            // Stats
            $table->integer('view_count')->default(0);
            $table->integer('comment_count')->default(0);
            $table->integer('share_count')->default(0);

            // Timestamps
            $table->timestamps();
            $table->timestamp('published_at')->nullable();

            $table->index('published_at');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};