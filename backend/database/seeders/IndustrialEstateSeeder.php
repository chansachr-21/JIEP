<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IndustrialEstateSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('industrial_estates')->insertOrIgnore([
            'id' => 1,
            'name' => 'Kawasan Industri Pulogadung',
            'slug' => 'kawasan-industri-pulogadung',
            'description' => 'Kawasan Industri Pulogadung (KIP) merupakan kawasan industri pertama dan terbesar di DKI Jakarta, dikelola oleh PT Jakarta Industrial Estate Pulogadung (PT JIEP). Kawasan ini telah beroperasi sejak tahun 1973 dan menjadi salah satu pusat industri manufaktur terkemuka di Indonesia.',
            'manager_name' => 'PT Jakarta Industrial Estate Pulogadung (PT JIEP)',
            'address' => 'Gedung Graha Dayaguna, Jl. Pulobuaran V, Blok JJ-4, Kawasan Industri Pulogadung',
            'city' => 'Jakarta Timur',
            'province' => 'DKI Jakarta',
            'area_hectares' => 433.00,
            'established_year' => 1973,
            'established_date' => '1973-06-26',
            'ownership_pemprov_pct' => 53.06,
            'ownership_danareksa_pct' => 46.94,
            'website' => 'https://jiep.co.id/',
            'phone' => '+62 21 4682 0449',
            'phone_secondary' => '(021) 3971 1973',
            'email' => null, // Email tidak dicantumkan — perlu verifikasi ke sumber resmi terbaru
            'latitude' => -6.194280, // Gedung Graha Dayaguna, Jl. Pulobuaran V, Blok JJ-4, KIP
            'longitude' => 106.919790,
            'verification_status' => 'verified',
            'data_source' => 'PT JIEP (jiep.co.id) & PT Danareksa Annual Report 2025',
            'source_url' => 'https://jiep.co.id/',
            'last_verified_at' => '2025-11-01',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
