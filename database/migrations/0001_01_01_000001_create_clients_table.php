<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email');
            $table->string('full_name')->nullable();
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('website')->nullable();
            $table->enum('source', ['website', 'referral', 'social', 'event', 'other'])->default('website');
            $table->enum('status', ['lead', 'client', 'past_client', 'subscriber'])->default('lead');
            $table->json('tags')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('is_subscribed')->default(true);
            $table->timestamps();

            $table->index('email');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};