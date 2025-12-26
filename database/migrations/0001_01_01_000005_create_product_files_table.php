<?php
// database/migrations/0001_01_01_000005_create_product_files_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignUuid('variation_id')->nullable()->constrained('product_variations')->onDelete('cascade');
            $table->string('file_name');
            $table->text('file_path');
            $table->bigInteger('file_size')->nullable();
            $table->string('file_type')->nullable();
            $table->string('version')->nullable();
            $table->boolean('is_main_file')->default(false);
            $table->integer('download_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_files');
    }
};