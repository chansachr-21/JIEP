<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->string('company_name'); // denormalized untuk kemudahan
            $table->string('title');
            $table->string('category')->nullable(); // teknik, administrasi, it, operasional, dll
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->string('employment_type')->nullable(); // full-time, part-time, kontrak
            $table->string('location')->nullable();
            $table->boolean('is_published')->default(true);
            $table->boolean('is_demo')->default(false);
            $table->date('published_at')->nullable();
            $table->date('deadline')->nullable();
            $table->string('source_url')->nullable();
            $table->string('data_source')->nullable();
            $table->enum('verification_status', ['verified', 'needs_verification', 'unverified'])->default('needs_verification');
            $table->timestamp('last_verified_at')->nullable();
            $table->timestamps();

            $table->index('category');
            $table->index('is_published');
            $table->index('deadline');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
