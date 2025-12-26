<?php
// database/migrations/0001_01_01_000017_create_quote_requests_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->string('name');
            $table->string('email');
            $table->string('company')->nullable();

            // Project details
            $table->string('project_type')->nullable();
            $table->text('description');
            $table->string('budget_range')->nullable();
            $table->string('timeline')->nullable();

            // Services needed
            $table->json('services_needed')->nullable();

            // Status
            $table->enum('status', ['new', 'contacted', 'quoted', 'accepted', 'rejected', 'archived'])->default('new');
            $table->foreignUuid('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('quoted_amount', 10, 2)->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};