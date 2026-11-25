<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industrial_estate_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('category'); // lahan, gudang, perkantoran, energi, umum, olahraga, infrastruktur, media, ukm, logistik
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('operational_status')->default('Belum terverifikasi');
            $table->string('phone')->nullable();
            // Verifikasi
            $table->enum('verification_status', ['verified', 'needs_verification', 'unverified'])->default('needs_verification');
            $table->string('data_source')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamp('last_verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('category');
            $table->index('verification_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
