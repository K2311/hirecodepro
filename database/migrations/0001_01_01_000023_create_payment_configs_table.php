<?php
// database/migrations/0001_01_01_000023_create_payment_configs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_configs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('provider', ['stripe', 'paypal', 'bank_transfer']);
            $table->boolean('is_active')->default(true);
            $table->json('config_data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_configs');
    }
};