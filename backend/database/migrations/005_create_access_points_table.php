<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('access_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industrial_estate_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('road_name')->nullable();
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('verification_status', ['verified', 'needs_verification', 'unverified'])->default('needs_verification');
            $table->string('data_source')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamp('last_verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_points');
    }
};
