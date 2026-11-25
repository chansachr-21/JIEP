<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_number')->unique(); // IND-YYYYMMDD-XXXX
            $table->string('title');
            $table->string('category'); // infrastruktur, keamanan, kebersihan, administrasi, lainnya
            $table->text('description');
            $table->string('location')->nullable();
            $table->string('reporter_name')->nullable(); // opsional, tidak wajib
            $table->enum('status', ['diterima', 'ditinjau', 'diproses', 'selesai', 'ditolak'])->default('diterima');
            $table->boolean('is_demo')->default(true); // selalu true - sistem demonstrasi
            $table->timestamps();

            $table->index('complaint_number');
            $table->index('status');
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
