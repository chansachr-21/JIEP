<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            IndustrialEstateSeeder::class,
            CompanySeeder::class,
            FacilitySeeder::class,
            AccessPointSeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}
