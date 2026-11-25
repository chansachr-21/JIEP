<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        // Pengumuman demonstrasi — berlabel jelas sebagai konten demo
        $announcements = [
            [
                'title' => '[DEMO] Sistem INDUSTRIA Aktif — Platform Informasi Kawasan Industri',
                'category' => 'demo',
                'content' => 'INDUSTRIA adalah platform informasi dan digitalisasi layanan Kawasan Industri Pulogadung yang dikembangkan sebagai proyek demonstrasi inovasi teknologi. Platform ini menampilkan informasi kawasan berdasarkan sumber resmi PT JIEP dan dokumen publik yang dapat diverifikasi. Fitur pengaduan dan sistem demonstrasi lainnya berfungsi sebagai contoh implementasi digitalisasi layanan kawasan industri. Data yang ditampilkan bersumber dari publikasi resmi dan telah diberi label status verifikasi.',
                'is_official' => false,
                'is_demo' => true,
                'is_published' => true,
                'published_at' => Carbon::now()->format('Y-m-d'),
                'source_url' => null,
                'data_source' => 'Tim Pengembang INDUSTRIA',
                'verification_status' => 'unverified',
            ],
            [
                'title' => 'Referensi: Uji Coba Sistem E-Gate Kawasan Industri Pulogadung',
                'category' => 'operasional',
                'content' => 'Berdasarkan pengumuman resmi PPID JIEP tertanggal 6 November 2025, PT Jakarta Industrial Estate Pulogadung melakukan uji coba sistem E-Gate pada tiga akses utama kawasan: Jl. Pulogadung Raya, Jl. Pulolentut, dan Jl. Pulolio. Pengumuman ini bersumber dari PPID JIEP dan digunakan sebagai referensi data dalam sistem INDUSTRIA. Untuk informasi resmi terbaru, kunjungi https://ppid.jiep.co.id/.',
                'is_official' => false,
                'is_demo' => false,
                'is_published' => true,
                'published_at' => '2025-11-06',
                'source_url' => 'https://ppid.jiep.co.id/',
                'data_source' => 'PPID JIEP — 6 November 2025',
                'verification_status' => 'verified',
            ],
        ];

        foreach ($announcements as $ann) {
            DB::table('announcements')->insertOrIgnore(array_merge($ann, [
                'industrial_estate_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
