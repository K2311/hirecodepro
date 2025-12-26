<?php
// database/migrations/0001_01_01_000003_create_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_description', 300)->nullable();
            $table->text('full_description')->nullable();
            $table->foreignUuid('category_id')->nullable()->constrained('product_categories')->onDelete('set null');
            $table->enum('product_type', ['code', 'template', 'api', 'plugin', 'tool', 'ebook'])->default('code');
            $table->decimal('base_price', 10, 2)->default(0);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_on_sale')->default(false);
            $table->enum('status', ['draft', 'active', 'archived'])->default('draft');

            // Technical details
            $table->json('tech_stack')->nullable();
            $table->text('dependencies')->nullable();
            $table->text('requirements')->nullable();
            $table->string('version')->default('1.0.0');
            $table->text('changelog')->nullable();

            // Files
            $table->string('cover_image_url')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('documentation_url')->nullable();
            $table->string('github_url')->nullable();
            $table->json('preview_images')->nullable();

            // License
            $table->string('license_type')->default('single_project');
            $table->text('license_terms')->nullable();

            // Statistics
            $table->integer('view_count')->default(0);
            $table->integer('download_count')->default(0);
            $table->integer('purchase_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);

            // SEO
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->string('meta_keywords', 500)->nullable();

            // Admin
            $table->foreignUuid('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->timestamp('published_at')->nullable();

            $table->index(['category_id', 'status']);
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};