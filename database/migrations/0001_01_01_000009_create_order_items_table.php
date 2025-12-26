<?php
// database/migrations/0001_01_01_000009_create_order_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignUuid('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignUuid('service_id')->nullable()->constrained('services')->onDelete('set null');
            $table->enum('item_type', ['product', 'service']);
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('subtotal', 10, 2);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('product_id');
            $table->index('service_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};