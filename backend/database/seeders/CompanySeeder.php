<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // PT Hexindo Adiperkasa Tbk — satu-satunya perusahaan yang dapat dikonfirmasi
        // keberadaannya di dalam kawasan berdasarkan dokumen resmi JIEP
        DB::table('companies')->insertOrIgnore([
            'industrial_estate_id' => 1,
            'name' => 'PT Hexindo Adiperkasa Tbk',
            'slug' => 'pt-hexindo-adiperkasa-tbk',
            'category' => 'alat-berat',
            'description' => 'PT Hexindo Adiperkasa Tbk adalah perusahaan yang bergerak di bidang distribusi alat berat Hitachi di Indonesia. Keberadaan perusahaan ini di Kawasan Industri Pulogadung dikonfirmasi berdasarkan dokumen resmi PT JIEP.',
            'address' => 'Kawasan Industri Pulogadung, Jakarta Timur',
            'phone' => null, // Kontak tidak diverifikasi untuk sistem ini
            'email' => null,
            'website' => 'https://www.hexindo-tbk.co.id/',
            'latitude' => -6.196046, // Jl. Pulo Kambing II Kav. I-II No. 33, Kawasan Industri Pulogadung
            'longitude' => 106.908966,
            'verification_status' => 'verified',
            'data_source' => 'Dokumen resmi PT JIEP',
            'source_url' => 'https://jiep.co.id/',
            'last_verified_at' => '2025-01-01',
            'is_featured' => true,
            'is_active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // CATATAN: Perusahaan lain dalam kawasan tidak dimasukkan sebagai data terverifikasi
        // karena memerlukan konfirmasi dari sumber resmi JIEP.
        // Gunakan fitur Import CSV untuk menambahkan perusahaan setelah verifikasi data.
    }
}
