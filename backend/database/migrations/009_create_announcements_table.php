<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industrial_estate_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->string('category')->default('umum'); // umum, operasional, keamanan, acara, demo
            $table->text('content');
            $table->boolean('is_official')->default(false); // true = dari JIEP resmi
            $table->boolean('is_demo')->default(false);    // true = konten demonstrasi
            $table->boolean('is_published')->default(true);
            $table->date('published_at')->nullable();
            $table->string('source_url')->nullable();
            $table->string('data_source')->nullable();
            $table->enum('verification_status', ['verified', 'needs_verification', 'unverified'])->default('needs_verification');
            $table->timestamps();

            $table->index('category');
            $table->index('is_published');
            $table->index('is_official');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
