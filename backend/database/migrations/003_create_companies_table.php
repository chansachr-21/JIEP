<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industrial_estate_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->nullable(); // manufaktur, logistik, perdagangan, dll
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            // Status & Verifikasi
            $table->enum('verification_status', ['verified', 'needs_verification', 'unverified'])->default('needs_verification');
            $table->string('data_source')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamp('last_verified_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('category');
            $table->index('verification_status');
            $table->index('is_active');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
