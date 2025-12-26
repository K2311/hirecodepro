<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change product_type to string to be more flexible
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_type', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            DB::statement("ALTER TABLE products MODIFY COLUMN product_type ENUM('code','template','api','plugin','tool','ebook','service') DEFAULT 'code'");
        });
    }
};
