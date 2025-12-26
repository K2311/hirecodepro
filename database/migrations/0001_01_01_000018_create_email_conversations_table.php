<?php
// database/migrations/0001_01_01_000018_create_email_conversations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('email_conversations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('thread_id')->nullable();
            $table->foreignUuid('client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->foreignUuid('inquiry_id')->nullable()->constrained('contact_inquiries')->onDelete('set null');
            $table->foreignUuid('quote_request_id')->nullable()->constrained('quote_requests')->onDelete('set null');
            $table->foreignUuid('order_id')->nullable()->constrained('orders')->onDelete('set null');

            // Email details
            $table->string('subject')->nullable();
            $table->string('from_email');
            $table->string('to_email');
            $table->json('cc_emails')->nullable();
            $table->json('bcc_emails')->nullable();

            // Content
            $table->text('body_text')->nullable();
            $table->text('body_html')->nullable();

            // Status
            $table->enum('direction', ['incoming', 'outgoing']);
            $table->enum('status', ['sent', 'delivered', 'read', 'failed'])->default('sent');

            // Metadata
            $table->string('message_id')->nullable();
            $table->json('references_ids')->nullable();
            $table->json('headers')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_conversations');
    }
};