<?php
// database/migrations/0001_01_01_000020_create_conversion_events_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('conversion_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('session_id')->nullable();
            $table->enum('event_type', ['product_view', 'add_to_cart', 'purchase', 'newsletter_signup', 'contact_form', 'demo_request', 'download']);
            $table->json('event_data');
            $table->string('page_path', 500)->nullable();
            $table->foreignUuid('client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversion_events');
    }
};