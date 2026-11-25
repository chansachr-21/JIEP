<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Tanah Kavling Industri',
                'category' => 'lahan',
                'description' => 'Penyewaan dan penjualan tanah kavling untuk kegiatan industri di dalam kawasan. Tersedia dalam berbagai ukuran sesuai kebutuhan tenant.',
                'operational_status' => 'Belum terverifikasi',
                'verification_status' => 'needs_verification',
                'data_source' => 'PT JIEP — jiep.co.id',
                'source_url' => 'https://jiep.co.id/',
            ],
            [
                'name' => 'Pergudangan',
                'category' => 'gudang',
                'description' => 'Fasilitas pergudangan modern untuk penyimpanan bahan baku, barang jadi, dan kegiatan logistik tenant kawasan industri.',
                'operational_status' => 'Belum terverifikasi',
                'verification_status' => 'needs_verification',
                'data_source' => 'PT JIEP — jiep.co.id',
                'source_url' => 'https://jiep.co.id/',
            ],
            [
                'name' => 'Bangunan Pabrik Siap Pakai (BPSP)',
                'category' => 'fasilitas_produksi',
                'description' => 'Bangunan pabrik yang telah siap digunakan untuk kegiatan produksi industri tanpa perlu membangun dari awal. Memudahkan perusahaan yang ingin segera beroperasi.',
                'operational_status' => 'Belum terverifikasi',
                'verification_status' => 'needs_verification',
                'data_source' => 'PT JIEP — jiep.co.id',
                'source_url' => 'https://jiep.co.id/',
            ],
            [
                'name' => 'Business Center',
                'category' => 'perkantoran',
                'description' => 'Pusat bisnis yang menyediakan ruang perkantoran dan fasilitas pendukung kegiatan usaha di dalam kawasan industri.',
                'operational_status' => 'Beroperasi',
                'verification_status' => 'verified',
                'latitude' => -6.193500,
                'longitude' => 106.918200,
                'data_source' => 'PT JIEP — jiep.co.id',
                'source_url' => 'https://jiep.co.id/',
            ],
            [
                'name' => 'Pertashop',
                'category' => 'energi',
                'description' => 'Fasilitas pengisian bahan bakar Pertamina (Pertashop) yang melayani kebutuhan bahan bakar kendaraan operasional di kawasan industri.',
                'operational_status' => 'Belum terverifikasi',
                'verification_status' => 'needs_verification',
                'data_source' => 'PT JIEP — jiep.co.id',
                'source_url' => 'https://jiep.co.id/',
            ],
            [
                'name' => 'Food Center',
                'category' => 'layanan_umum',
                'description' => 'Pusat kuliner yang menyediakan berbagai pilihan makanan dan minuman untuk memenuhi kebutuhan karyawan dan pengguna kawasan industri.',
                'operational_status' => 'Beroperasi',
                'verification_status' => 'verified',
                'latitude' => -6.191000,
                'longitude' => 106.907500,
                'data_source' => 'PT JIEP — jiep.co.id',
                'source_url' => 'https://jiep.co.id/',
            ],
            [
                'name' => 'Sport Center',
                'category' => 'olahraga',
                'description' => 'Fasilitas olahraga dan rekreasi untuk mendukung kesehatan dan kesejahteraan karyawan serta penghuni kawasan industri.',
                'operational_status' => 'Belum terverifikasi',
                'verification_status' => 'needs_verification',
                'data_source' => 'PT JIEP — jiep.co.id',
                'source_url' => 'https://jiep.co.id/',
            ],
            [
                'name' => 'Lahan Utilitas',
                'category' => 'infrastruktur',
                'description' => 'Area yang dialokasikan untuk infrastruktur utilitas kawasan, termasuk jaringan listrik, air, dan sistem drainase kawasan industri.',
                'operational_status' => 'Belum terverifikasi',
                'verification_status' => 'needs_verification',
                'data_source' => 'PT JIEP — jiep.co.id',
                'source_url' => 'https://jiep.co.id/',
            ],
            [
                'name' => 'Media Luar Ruang',
                'category' => 'media',
                'description' => 'Fasilitas media luar ruang (billboard, baliho, dan sarana periklanan lainnya) yang tersedia untuk disewa di lokasi strategis dalam kawasan industri.',
                'operational_status' => 'Belum terverifikasi',
                'verification_status' => 'needs_verification',
                'data_source' => 'PT JIEP — jiep.co.id',
                'source_url' => 'https://jiep.co.id/',
            ],
            [
                'name' => 'Sentra Usaha Industri Kecil (SUIK)',
                'category' => 'ukm',
                'description' => 'Fasilitas yang diperuntukkan bagi usaha industri kecil dan menengah yang ingin beroperasi di dalam kawasan industri Pulogadung.',
                'operational_status' => 'Beroperasi',
                'verification_status' => 'verified',
                'latitude' => -6.185200,
                'longitude' => 106.903500,
                'data_source' => 'PT JIEP — jiep.co.id',
                'source_url' => 'https://jiep.co.id/',
            ],
            [
                'name' => 'Layanan Logistik',
                'category' => 'logistik',
                'description' => 'Dukungan layanan logistik terintegrasi untuk memperlancar rantai pasok dan distribusi produk tenant kawasan industri.',
                'operational_status' => 'Belum terverifikasi',
                'verification_status' => 'needs_verification',
                'data_source' => 'PT JIEP — jiep.co.id',
                'source_url' => 'https://jiep.co.id/',
            ],
        ];

        foreach ($facilities as $facility) {
            $lat = $facility['latitude'] ?? null;
            $lng = $facility['longitude'] ?? null;
            DB::table('facilities')->insertOrIgnore(array_merge($facility, [
                'industrial_estate_id' => 1,
                'latitude' => $lat,
                'longitude' => $lng,
                'phone' => null,
                'is_active' => true,
                'last_verified_at' => $lat ? '2025-11-01' : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
