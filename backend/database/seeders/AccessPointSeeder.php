<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccessPointSeeder extends Seeder
{
    public function run(): void
    {
        $accessPoints = [
            [
                'name' => 'Akses Utama Jl. Pulogadung Raya',
                'road_name' => 'Jl. Pulogadung Raya',
                'description' => 'Akses gerbang utama Kawasan Industri Pulogadung yang terintegrasi dengan sistem E-Gate JIEP.',
                'latitude' => -6.182000,
                'longitude' => 106.900500,
                'verification_status' => 'verified',
                'data_source' => 'PPID JIEP — Pengumuman Uji Coba E-Gate, 6 November 2025',
                'source_url' => 'https://ppid.jiep.co.id/',
            ],
            [
                'name' => 'Akses Utama Jl. Pulolentut',
                'road_name' => 'Jl. Pulolentut',
                'description' => 'Akses gerbang barat Kawasan Industri Pulogadung terintegrasi dengan sistem E-Gate JIEP.',
                'latitude' => -6.188300,
                'longitude' => 106.899800,
                'verification_status' => 'verified',
                'data_source' => 'PPID JIEP — Pengumuman Uji Coba E-Gate, 6 November 2025',
                'source_url' => 'https://ppid.jiep.co.id/',
            ],
            [
                'name' => 'Akses Utama Jl. Pulolio',
                'road_name' => 'Jl. Pulolio',
                'description' => 'Akses gerbang timur Kawasan Industri Pulogadung terintegrasi dengan sistem E-Gate JIEP.',
                'latitude' => -6.181200,
                'longitude' => 106.915000,
                'verification_status' => 'verified',
                'data_source' => 'PPID JIEP — Pengumuman Uji Coba E-Gate, 6 November 2025',
                'source_url' => 'https://ppid.jiep.co.id/',
            ],
        ];

        foreach ($accessPoints as $ap) {
            DB::table('access_points')->insertOrIgnore(array_merge($ap, [
                'industrial_estate_id' => 1,
                'last_verified_at' => '2025-11-06',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
