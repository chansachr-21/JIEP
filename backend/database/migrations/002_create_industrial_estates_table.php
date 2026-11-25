<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('industrial_estates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('manager_name')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->decimal('area_hectares', 10, 2)->nullable();
            $table->integer('established_year')->nullable();
            $table->date('established_date')->nullable();
            $table->decimal('ownership_pemprov_pct', 5, 2)->nullable();
            $table->decimal('ownership_danareksa_pct', 5, 2)->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_secondary')->nullable();
            $table->string('email')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            // Verifikasi data
            $table->enum('verification_status', ['verified', 'needs_verification', 'unverified'])->default('needs_verification');
            $table->string('data_source')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamp('last_verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('industrial_estates');
    }
};
