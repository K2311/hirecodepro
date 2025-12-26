<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            DB::statement("ALTER TABLE products MODIFY COLUMN product_type ENUM('code', 'template', 'api', 'plugin', 'tool', 'ebook', 'service') DEFAULT 'code'");
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            DB::statement("ALTER TABLE products MODIFY COLUMN product_type ENUM('code', 'template', 'api', 'plugin', 'tool', 'ebook') DEFAULT 'code'");
        });
    }
};
